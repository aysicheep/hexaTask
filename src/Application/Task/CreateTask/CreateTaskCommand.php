<?php
declare(strict_types=1);
namespace App\Application\Task\CreateTask;


class CreateTaskCommand {
    public function __construct(
        public readonly string $taskTitle, 
        public readonly string $workspaceId, 
        public readonly ?string $memberId)
    {}
}