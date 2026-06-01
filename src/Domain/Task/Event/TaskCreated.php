<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Shared\DomainEvent;
use App\Domain\Task\TaskId;
use App\Domain\Workspace\WorkspaceId;

/** Raised when a new task is created inside a workspace. */
final class TaskCreated extends DomainEvent
{
    public function __construct(
        public readonly TaskId $taskId,
        public readonly WorkspaceId $workspaceId
    ) {
        parent::__construct();
    }
}
