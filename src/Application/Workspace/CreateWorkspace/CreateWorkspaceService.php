<?php
declare(strict_types=1);
namespace App\Application\Workspace\CreateWorkspace;

use App\Domain\Member\MemberId;
use App\Domain\Workspace\Workspace;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Workspace\WorkspaceName;
use App\Domain\Workspace\WorkspaceRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Service applicatif orchestrant la création d'un workspace.
 *
 * Génère un identifiant UUID, hydrate les value objects, persiste l'agrégat
 * et dispatche les événements domaine enregistrés.
 */
class CreateWorkspaceService
{
    public function __construct(
        private WorkspaceRepositoryInterface $workspaceRepositoryInterface,
        private EventDispatcherInterface $eventDispatcherInterface
    ) {}

    /**
     * Exécute la création d'un workspace.
     *
     * @param CreateWorkspaceCommand $createWorkspaceCommand Données de la commande (nom, memberId propriétaire).
     * @throws \InvalidArgumentException Si le nom est vide ou dépasse 100 caractères.
     */
    public function create(CreateWorkspaceCommand $createWorkspaceCommand): void
    {
        $workspaceId = WorkspaceId::generate();
        $workspaceName = new WorkspaceName($createWorkspaceCommand->workspaceName);
        $memberId = new MemberId($createWorkspaceCommand->memberId);
        $workspace = Workspace::create($workspaceId, $workspaceName, $memberId);
        $this->workspaceRepositoryInterface->save($workspace);
        $events = $workspace->releaseEvents();

        foreach ($events as $event) {
            $this->eventDispatcherInterface->dispatch($event);
        }
    }
}