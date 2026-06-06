<?php

declare(strict_types=1);

namespace App\Domain\Workspace;

use App\Domain\Workspace\Exception\InvalidWorspaceIdException;
use Ramsey\Uuid\Uuid;

/**
 * Value object representing a workspace's unique identifier (UUID v4).
 *
 * Validates UUID format on construction to prevent invalid IDs from entering the domain.
 */
final readonly class WorkspaceId
{
    /**
     * @throws \InvalidArgumentException If $value is not a valid UUID v4 string.
     */
    public function __construct(private string $value)
    {
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $value) !== 1) {
            throw new InvalidWorspaceIdException('Invalid UUID format');
        }
    }

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

    public function equals(WorkspaceId $other): bool
    {
        return $this->value === $other->value;
    }
}
