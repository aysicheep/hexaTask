<?php
declare(strict_types=1);
namespace Tests\Integration\Infrastructure\Persistence\Doctrine;

use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\TaskTitle;
use App\Domain\Workspace\WorkspaceId;
use App\Infrastructure\Persistence\Doctrine\DoctrineTaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Override;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase; 
final class DoctrineTaskRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private TaskRepositoryInterface $taskRepository;
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $this->taskRepository = new DoctrineTaskRepository($this->em);
        $this->em->getConnection()->beginTransaction();
    }

    #[Override]
    protected function tearDown(): void
    {
        $connection = $this->em->getConnection();
        if ($connection->isTransactionActive()) {
            $connection->rollBack();
        }
        $this->em->clear();
        parent::tearDown();
    }

    public function testSave(): void
    {
        $taskId = TaskId::generate();
        $taskTitle = TaskTitle::create("test");
        $workspaceId = WorkspaceId::generate();
        $task = Task::create($taskId,$taskTitle,$workspaceId);
        $this->taskRepository->save($task);
        $this->em->clear();
        $savedTask = $this->taskRepository->findById($taskId);
        $this->assertNotNull($savedTask);
        $this->assertSame(
            $taskId->value(),
            $savedTask->id()->value()
        );
        $this->assertSame(
            $savedTask->title()->value(),
            'test'
        );

        $this->assertSame(
            $workspaceId->value(),
            $savedTask->workspaceId()->value()
        );
    }  
    
    public function testFindByIdReturnsNullWhenNotFound(): void
    {
            $taskId = TaskId::generate();
            $this->assertNull($this->taskRepository->findById($taskId));
    }
    public function testGetAllByWorkspaceId(): void
    {
        $workspaceId1 = WorkspaceId::generate();
        $workspaceId2 = WorkspaceId::generate();

        $task1 = Task::create(
            TaskId::generate(),
            TaskTitle::create('test1'),
            $workspaceId1
        );

        $task2 = Task::create(
            TaskId::generate(),
            TaskTitle::create('test2'),
            $workspaceId1
        );

        $task3 = Task::create(
            TaskId::generate(),
            TaskTitle::create('test3'),
            $workspaceId2
        );

        $this->taskRepository->save($task1);
        $this->taskRepository->save($task2);
        $this->taskRepository->save($task3);

        
        $this->em->clear();

        $tasksWorkspace1 = $this->taskRepository->getAllByWorkspaceId($workspaceId1);
        $idsWorkspace1 = array_map(
            static fn (Task $t): string => $t->id()->value(),
            $tasksWorkspace1
        );
        $tasksWorkspace2 = $this->taskRepository->getAllByWorkspaceId($workspaceId2);
        $idsWorkspace2 = array_map(
                    static fn (Task $t): string => $t->id()->value(),
                    $tasksWorkspace2
                );
        $this->assertCount(2, $tasksWorkspace1);
        $this->assertCount(1, $tasksWorkspace2);

        $this->assertContainsEquals($task1->id()->value(), $idsWorkspace1);
        $this->assertContainsEquals($task2->id()->value(), $idsWorkspace1);
        $this->assertContainsEquals($task3->id()->value(), $idsWorkspace2);
    }
}