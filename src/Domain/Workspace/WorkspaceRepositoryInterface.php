<?php
    declare(strict_types = 1);
    namespace App\Domain\Workspace;
    interface WorkspaceRepositoryInterface {
        public function save(Workspace $workspace):void;
        public function findById(WorkspaceId $workspaceId): ?Workspace;
    }