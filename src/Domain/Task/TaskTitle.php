<?php

declare(strict_types=1);

namespace App\Domain\Task;
use App\Domain\Task\Exception\InvalidTaskTitle;
/**
 * Value object representing a task title.
 *
 * Validates that the title is non-empty and respects length constraints.
 */
final readonly class TaskTitle
{
    /**
     * Create a new TaskTitle value object.
     *
     * @param string $title The title text
     */
    private function __construct(public readonly string $title)
    {
    }

    /**
     * Create a new TaskTitle value object.
     *
     * @param string $title The title text
     * @throws InvalidTaskTitle If the title is empty or too long
     */
    public static function create(string $title) : self {
        if ($title === '') {
            throw new InvalidTaskTitle('The title is empty.');
        }

        if (mb_strlen($title) > 250) {
            throw new InvalidTaskTitle('The title is too long.');
        }
        return new self(trim($title));
    }

    /**
     * Get the raw task title value.
     *
     * @return string The task title
     */
    public function value(): string
    {
        return $this->title;
    }

    /**
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->title;
    }
}
