<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Shared\DomainEvent;
use App\Domain\Task\TaskId;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Task\TaskStatus;

/** Raised when a task transitions to a new status. */
final class TaskStatusChanged extends DomainEvent
{
    public function __construct(
        public readonly TaskId $taskId,
        public readonly TaskStatus $taskStatus,
    ) {
        parent::__construct();
    }
}
