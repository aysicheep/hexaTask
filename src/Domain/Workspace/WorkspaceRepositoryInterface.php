<?php
    declare(strict_types = 1);
    namespace App\Domain\Workspace;
    /**
     * Contrat de persistance pour l'agrégat Workspace.
     *
     * Les implémentations (Doctrine, InMemory) vivent dans les couches
     * Infrastructure et Tests — jamais dans le Domain.
     */
    interface WorkspaceRepositoryInterface
    {
        /** Persiste un workspace (création ou mise à jour). */
        public function save(Workspace $workspace): void;

        /**
         * Recherche un workspace par son identifiant.
         *
         * @return Workspace|null null si aucun workspace ne correspond à cet identifiant.
         */
        public function findById(WorkspaceId $workspaceId): ?Workspace;
    }