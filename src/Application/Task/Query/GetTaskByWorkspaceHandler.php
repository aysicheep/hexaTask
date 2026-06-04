<?php 
declare(strict_types=1);
namespace App\Application\Task\Query;

use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Task\Task;

class GetTaskByWorkspaceHandler{
    public function __construct(
    private TaskRepositoryInterface $taskRepositoryInterface)
    {
    }

    /** @return TaskReadModel[] */
    public function __invoke(GetTaskByWorkspaceQuery $getTaskByWorkspaceQuery): array{
        $workpaceId = new WorkspaceId($getTaskByWorkspaceQuery->workspaceId);
        $tasks = $this->taskRepositoryInterface->getAllByWorkspaceId($workpaceId);
        return array_map($this->toReadModel(...), $tasks);
    }

    private function toReadModel(Task $task) :TaskReadModel {
        return new TaskReadModel(
            $task->id()->value(),
            $task->title()->value(),
            $task->status()->label(),
            $task->workspaceId()->value(),
            $task->assignedTo()?->value()
        );
    }
    
}