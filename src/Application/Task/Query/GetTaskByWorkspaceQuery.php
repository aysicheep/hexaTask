<?php 
declare(strict_types=1);
namespace App\Application\Task\Query;

class GetTaskByWorkspaceQuery {
    public function __construct(public readonly string $workspaceId)
    {
    }
}