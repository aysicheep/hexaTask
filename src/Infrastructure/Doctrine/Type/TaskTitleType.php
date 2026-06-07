<?php
declare(strict_types=1);
namespace App\Infrastructure\Doctrine\Type;
use App\Domain\Task\TaskTitle;
use App\Infrastructure\Doctrine\Type\Abstract\AbstractStringType;
use Override;

final class TaskTitleType extends AbstractStringType 
{

    public const NAME = "task_title";

    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    protected function fromString(string $value): TaskTitle
    {
        return TaskTitle::create($value);
    }
}