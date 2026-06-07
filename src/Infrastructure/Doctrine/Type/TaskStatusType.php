<?php
declare(strict_types=1);
namespace App\Infrastructure\Doctrine\Type;
use App\Domain\Task\TaskStatus;
use App\Infrastructure\Doctrine\Type\Abstract\AbstractEnumType;
use Override;

final class TaskStatusType extends AbstractEnumType 
{

    public const NAME = "task_status";

    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    protected function fromString(string $value): TaskStatus
    {
        return TaskStatus::from($value);
    }
}