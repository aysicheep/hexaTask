<?php
declare(strict_types=1);
namespace App\Application\Task\CreateTask;


/**
 * Commande pour créer une nouvelle tâche dans un workspace.
 *
 * @property string      $taskTitle   Titre de la tâche (non vide, max 250 caractères).
 * @property string      $workspaceId UUID du workspace auquel rattacher la tâche.
 * @property string|null $memberId    UUID du membre à assigner immédiatement, ou null.
 */
class CreateTaskCommand
{
    public function __construct(
        public readonly string $taskTitle,
        public readonly string $workspaceId,
        public readonly ?string $memberId
    ) {}
}