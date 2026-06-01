<?php
declare(strict_types=1);

    namespace App\Domain\Task;
    use App\Domain\Workspace\WorkspaceId;
    interface TaskRepositoryInterface {

        public function save(Task $task): void;
        public function findById(TaskId $taskId): ?Task;
        /** @return Task[] */
        public function getAllByWorkspaceId(WorkspaceId $workspaceId): array;
    }