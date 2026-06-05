<?php 
declare(strict_types=1);
namespace App\Application\Workspace\Query;

class WorkspaceReadModel {
    public function __construct(public readonly string $workspaceId,
    public readonly string $workspaceName, public readonly string $ownerId)
    {
    }
}