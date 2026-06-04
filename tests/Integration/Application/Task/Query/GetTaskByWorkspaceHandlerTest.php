<?php 
declare(strict_types=1);
namespace Tests\Integration\Application\Task\Query;

use App\Application\Task\Query\GetTaskByWorkspaceHandler;
use App\Application\Task\Query\GetTaskByWorkspaceQuery;
use App\Application\Task\Query\TaskReadModel;
use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\TaskTitle;
use App\Domain\Workspace\WorkspaceId;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tests\Integration\InMemory\InMemoryTaskRepository;

#[CoversClass(GetTaskByWorkspaceHandler::class)]
final class GetTaskByWorkspaceHandlerTest extends TestCase{

    private InMemoryTaskRepository $inMemoryRepository;
    private GetTaskByWorkspaceHandler $handler;
    private WorkspaceId $workspaceId;
    private GetTaskByWorkspaceQuery $query;

    #[Override]
    protected function setUp(): void
    {
        $this->inMemoryRepository = new InMemoryTaskRepository();
        $this->handler = new GetTaskByWorkspaceHandler($this->inMemoryRepository);
        $this->workspaceId = WorkspaceId::generate();
        $this->query = new GetTaskByWorkspaceQuery($this->workspaceId->value());

    }

    private function createTask() :Task{
        $taskTitle = TaskTitle::create("Task test handler");
        $taskId = TaskId::generate();
        return Task::create($taskId,$taskTitle,$this->workspaceId);
    }
    private function saveTask(Task $task) :void {
        $this->inMemoryRepository->save($task);
    }

    public function testHandleReturnsTaskReadModels() :void{
        $task = $this->createTask();
        $this->saveTask($task);
        $taskReadModels = ($this->handler)($this->query);
        $this->assertNotEmpty($taskReadModels);
        $this->assertContainsOnlyInstancesOf(TaskReadModel::class, $taskReadModels);
    }

}