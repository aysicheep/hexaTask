<?php
declare(strict_types=1);

    namespace App\Domain\Task;
    use App\Domain\Workspace\WorkspaceId;

    /**
     * Contrat de persistance pour l'agrégat Task.
     *
     * Les implémentations (Doctrine, InMemory) vivent dans les couches
     * Infrastructure et Tests — jamais dans le Domain.
     */
    interface TaskRepositoryInterface
    {
        /** Persiste une tâche (création ou mise à jour). */
        public function save(Task $task): void;

        /**
         * Recherche une tâche par son identifiant.
         *
         * @return Task|null null si aucune tâche ne correspond à cet identifiant.
         */
        public function findById(TaskId $taskId): ?Task;

        /**
         * Retourne toutes les tâches appartenant à un workspace donné.
         *
         * @return Task[]
         */
        public function getAllByWorkspaceId(WorkspaceId $workspaceId): array;
    }