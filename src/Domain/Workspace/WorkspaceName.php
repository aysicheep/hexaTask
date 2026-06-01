<?php

declare(strict_types=1);

namespace App\Domain\Workspace;

use InvalidArgumentException;

/**
 * Value object representing a workspace name.
 *
 * Ensures the name is non-empty and within length limits.
 */
final readonly class WorkspaceName
{
    private string $value;

    /**
     * @throws InvalidArgumentException If $value is empty or exceeds 100 characters.
     */
    public function __construct(string $value)
    {

        $value = trim($value);
        if ($value === '') {
            throw new InvalidArgumentException('Empty name');
        }
        if (mb_strlen($value) > 100) {
            throw new InvalidArgumentException('Too long');
        }

        $this->value = $value;
    }

    /**
     * Get the raw workspace name value.
     *
     * @return string The workspace name
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Magic string representation of the workspace name.
     *
     * @return string The workspace name
     */
    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(WorkspaceName $other): bool
    {
        return $this->value === $other->value;
    }
}
