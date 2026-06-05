<?php
declare(strict_types=1);
namespace App\Application\Workspace\CreateWorkspace;

/**
 * Commande pour créer un nouveau workspace.
 *
 * @property string      $workspaceId   UUID du workspace à créer.
 * @property string      $workspaceName Nom du workspace (non vide, max 100 caractères).
 * @property string|null $memberId      UUID du propriétaire (OWNER), ou null si généré.
 */
class CreateWorkspaceCommand
{
    public function __construct(
        public readonly string $workspaceId,
        public readonly string $workspaceName,
        public readonly ?string $memberId
    ) {}
}