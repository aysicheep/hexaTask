<?php

declare(strict_types=1);

namespace App\Domain\Workspace\Event;

use App\Domain\Workspace\WorkspaceId;
use App\Domain\Member\MemberId;
use App\Domain\Shared\DomainEvent;

/**
 * Événement émis lorsqu'un nouveau workspace est créé.
 *
 * @property WorkspaceId $workspaceId Identifiant du workspace nouvellement créé.
 * @property MemberId $memberId       Identifiant du propriétaire (OWNER) du workspace.
 */
final class WorkspaceCreated extends DomainEvent
{
    public function __construct(
        public readonly WorkspaceId $workspaceId,
        public readonly MemberId $memberId
    ) {
        parent::__construct();
    }
}
