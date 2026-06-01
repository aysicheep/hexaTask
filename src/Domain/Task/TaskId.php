<?php

declare(strict_types=1);

namespace App\Domain\Task;

use Ramsey\Uuid\Uuid;

/**
 * Value object representing a task's unique identifier (UUID v4).
 */
final readonly class TaskId
{
    public function __construct(private string $value) {}

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
