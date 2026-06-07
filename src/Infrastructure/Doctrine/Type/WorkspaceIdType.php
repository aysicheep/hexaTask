<?php
declare(strict_types=1);
namespace App\Infrastructure\Doctrine\Type;
use App\Domain\Workspace\WorkspaceId;
use App\Infrastructure\Doctrine\Type\Abstract\AbstractGuidType;
use Override;

final class WorkspaceIdType extends AbstractGuidType 
{

    public const NAME = "workspace_id";

    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    protected function fromString(string $value): WorkspaceId
    {
        return new WorkspaceId($value);
    }
}