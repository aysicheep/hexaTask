<?php

declare(strict_types=1);

namespace App\Domain\Workspace;

use App\Domain\Workspace\Exception\EmptyWorkspaceNameException;
use App\Domain\Workspace\Exception\WorkspaceNameTooLongException;
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
     * @throws WorkspaceNameTooLongException If $value is exceeds 100 characters.
     * @throws EmptyWorkspaceNameException If $value is empty.
     */
    public function __construct(string $value)
    {

        $value = trim($value);
        if ($value === '') {
            throw new EmptyWorkspaceNameException('Empty name');
        }
        if (mb_strlen($value) > 100) {
            throw new WorkspaceNameTooLongException('Too long');
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
