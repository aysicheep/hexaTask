<?php
declare(strict_types=1);
namespace App\Application\Workspace\CreateWorkspace;

class CreateWorkspaceCommand 
{
    public function __construct(public readonly string $workspaceId,
    public readonly string $workspaceName,
    public readonly ?string $memberId){}
}