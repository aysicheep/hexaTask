<?php

declare(strict_types=1);

namespace App\Domain\Workspace\Event;

use App\Domain\Workspace\WorkspaceId;
use App\Domain\Member\MemberId;
use App\Domain\Shared\DomainEvent;

final class WorkspaceCreated extends DomainEvent
{
    public function __construct(
        public readonly WorkspaceId $workspaceId,
        public readonly MemberId $memberId
    ) {
        parent::__construct();
    }

}
