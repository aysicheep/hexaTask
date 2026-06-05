<?php
declare(strict_types=1);
namespace App\Application\Task\Query;

/**
 * Read model représentant une tâche pour les besoins de lecture (queries).
 *
 * Objet plat sans logique métier, conçu pour être sérialisé ou affiché directement.
 *
 * @property string      $id          UUID de la tâche.
 * @property string      $taskTitle   Titre de la tâche.
 * @property string      $status      Libellé lisible du statut (ex: "En cours").
 * @property string      $workspaceId UUID du workspace auquel appartient la tâche.
 * @property string|null $assignedTo  UUID du membre assigné, ou null si non assignée.
 */
class TaskReadModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $taskTitle,
        public readonly string $status,
        public readonly string $workspaceId,
        public readonly ?string $assignedTo
    ) {}
}