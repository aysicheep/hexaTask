<?php

declare(strict_types=1);

namespace App\Domain\Task;

/**
 * Represents the lifecycle status of a task.
 *
 * Allowed transitions: TODO → IN_PROGRESS | COMPLETED, IN_PROGRESS → COMPLETED.
 * COMPLETED is a terminal state with no further transitions.
 */
enum TaskStatus: string
{
    case TODO = "todo";
    case IN_PROGRESS = "in_progress";
    case COMPLETED = "completed";

    /**
     * Returns true if transitioning from the current status to $next is allowed.
     */
    public function canTransitionTo(self $next): bool
    {
        return match ($this) {
            self::TODO => in_array($next, [self::IN_PROGRESS, self::COMPLETED]),
            self::IN_PROGRESS => in_array($next, [self::COMPLETED]),
            self::COMPLETED => false,
        };
    }

    /** Returns the human-readable label for the status. */
    public function label(): string
    {
        return match ($this) {
            self::TODO => 'A faire',
            self::IN_PROGRESS => 'En cours',
            self::COMPLETED => 'Terminé',
        };
    }

}
