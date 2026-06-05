<?php 
declare(strict_types=1);
namespace App\Application\Workspace\Query;

/**
 * Read model représentant un workspace pour les besoins de lecture (queries).
 *
 * Objet plat sans logique métier, conçu pour être sérialisé ou affiché directement.
 *
 * @property string $workspaceId   UUID du workspace.
 * @property string $workspaceName Nom du workspace.
 * @property string $ownerId       UUID du propriétaire (OWNER) du workspace.
 */
class WorkspaceReadModel
{
    public function __construct(
        public readonly string $workspaceId,
        public readonly string $workspaceName,
        public readonly string $ownerId
    ) {}
}