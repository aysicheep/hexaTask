<?php

declare(strict_types=1);

namespace App\Domain\Shared;

/**
 * Base class for all domain events.
 *
 * Every event is timestamped at construction to record when it occurred.
 */
abstract class DomainEvent
{
    public readonly \DateTimeImmutable $createdAt;
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
