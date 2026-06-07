<?php
declare(strict_types=1);
namespace App\Infrastructure\Doctrine\Type;
use App\Domain\Workspace\WorkspaceName;
use App\Infrastructure\Doctrine\Type\Abstract\AbstractStringType;
use Override;

final class WorkspaceNameType extends AbstractStringType 
{

    public const NAME = "workspace_name";

    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    protected function fromString(string $value): WorkspaceName
    {
        return new WorkspaceName($value);
    }
}