<?php 
declare(strict_types=1);
namespace Tests\Integration\InMemory;
use App\Domain\Workspace\Workspace;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Workspace\WorkspaceRepositoryInterface;

final class InMemoryWorkspaceRepository implements WorkspaceRepositoryInterface 
{
    /** @var Workspace[] */
    private array $workspaces =[];

    public function save(Workspace $workspace) :void {
        $this->workspaces[$workspace->id()->value()] = $workspace;
    }
    
    public function findById(WorkspaceId $workspaceId): ?Workspace
    {
        return $this->workspaces[$workspaceId->value()] ?? null;
    }
}