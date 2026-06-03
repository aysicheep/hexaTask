<?php
declare(strict_types=1);
namespace Tests\Integration\InMemory;

use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\Workspace\WorkspaceId;

final class InMemoryTaskRepository implements TaskRepositoryInterface 
{
        /** @var Task[] */
        private array $tasks = [];
        public function save(Task $task): void{
            $this->tasks[$task->id()->value()] = $task;
        }
        public function findById(TaskId $taskId): ?Task{
            return $this->tasks[$taskId->value()] ?? null;
        }
        /** @return Task[] */
        public function getAllByWorkspaceId(WorkspaceId $workspaceId): array {
            return array_filter($this->tasks,fn(Task $task) => $task->workspaceId()->equals($workspaceId));
        }
}