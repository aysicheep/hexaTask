<?php
declare(strict_types=1);
namespace Tests\Integration\Application\Task;

use App\Application\Task\CompleteTask\CompleteTaskCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tests\Integration\InMemory\InMemoryTaskRepository;
use App\Application\Task\CompleteTask\CompleteTaskService;
use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskStatus;
use App\Domain\Task\TaskTitle;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Task\Exception\TaskNotFoundException;

class CompleteTaskServiceTest extends TestCase {
    private InMemoryTaskRepository $inMemoryTaskRepository;
    private CompleteTaskService $completeTaskService;
    protected function setUp(): void
    {
        $this->inMemoryTaskRepository = new InMemoryTaskRepository();
        $this->completeTaskService = new CompleteTaskService($this->inMemoryTaskRepository,$this->createStub(EventDispatcherInterface::class));
    }
    public function testCompleteTaskSuccess() :void{
        $taskId = TaskId::generate();
        $worksapceId = WorkspaceId::generate();
        $taskTitle = TaskTitle::create('tertndlskf');
        $task = Task::create($taskId,$taskTitle,$worksapceId);
        $this->inMemoryTaskRepository->save($task);
        $command =  new CompleteTaskCommand($taskId->value());
        $this->completeTaskService->complete($command);
        $this->assertSame(TaskStatus::COMPLETED, $this->inMemoryTaskRepository->findById($taskId)->status());
    }

    public function testCompleteTaskThrowsExeptionWhenTaskNotFound() {
        $this->expectException(TaskNotFoundException::class);
        $taskId = TaskId::generate();
        $worksapceId = WorkspaceId::generate();
        $taskTitle = TaskTitle::create('tertndlskf');
        $task = Task::create($taskId,$taskTitle,$worksapceId);
        $command =  new CompleteTaskCommand($taskId->value());
        $this->completeTaskService->complete($command);
        $taskfound = $this->inMemoryTaskRepository->findById($taskId);
    }
}