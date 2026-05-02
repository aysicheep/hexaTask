<?php 
    declare(strict_types=1);
    namespace App\Domain\Task;

use InvalidArgumentException;

    /**
     * Value object representing a task title.
     *
     * Validates that the title is non-empty and respects length constraints.
     */
    final readonly class TaskTitle
    {
        private string $value;

        /**
         * Create a new TaskTitle value object.
         *
         * @param string $value The title text
         * @throws InvalidArgumentException If the title is empty or too long
         */
        public function __construct(string $value)
        {
            if ($value === '') {
                throw new InvalidArgumentException('Empty title');
            }

            if (mb_strlen($value) > 250) {
                throw new InvalidArgumentException('Too long');
            }

            $this->value = $value;
        }

        /**
         * Get the raw task title value.
         *
         * @return string The task title
         */
        public function value(): string
        {
            return $this->value;
        }

        public function __toString()
        {
            return $this->value;
        }
    }
?>