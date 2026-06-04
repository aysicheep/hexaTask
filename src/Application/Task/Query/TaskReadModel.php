<?php
declare(strict_types=1);
namespace App\Application\Task\Query;

class TaskReadModel {
    
    public function __construct(public readonly string $id,
    public readonly string $taskTitle,
    public readonly string $status,
    public readonly string $workspaceId,
    public readonly ?string $assignedTo)
    {
    }
}