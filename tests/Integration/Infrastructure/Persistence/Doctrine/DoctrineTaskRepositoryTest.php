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
}