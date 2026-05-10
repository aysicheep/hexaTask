<?php
declare(strict_types=1);
namespace App\Domain\Shared\Task;
use Ramsey\Uuid\Uuid;
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

    public function __toString()
    {
        return $this->value;
    }
}