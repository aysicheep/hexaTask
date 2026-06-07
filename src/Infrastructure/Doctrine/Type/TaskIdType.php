<?php
declare(strict_types=1);
namespace App\Infrastructure\Doctrine\Type;
use App\Domain\Task\TaskId;
use App\Infrastructure\Doctrine\Type\Abstract\AbstractGuidType;
use Override;

final class TaskIdType extends AbstractGuidType 
{

    public const NAME = "task_id";

    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    protected function fromString(string $value): TaskId
    {
        return new TaskId($value);
    }
}