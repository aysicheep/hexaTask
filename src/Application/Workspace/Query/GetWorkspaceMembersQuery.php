<?php 
declare(strict_types=1);
namespace App\Application\Workspace\Query;

class GetWorkspaceMembersQuery {
    public function __construct(public readonly string $workspaceId)
    {
        
    }
}