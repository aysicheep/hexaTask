<?php

declare(strict_types=1);

namespace App\Domain\Member\Event;

use App\Domain\Shared\DomainEvent;
use App\Domain\Member\MemberId;
use App\Domain\Member\MemberRole;

final class MemberCreated extends DomainEvent
{
    public function __construct(public readonly MemberId $memberId)
    {
        parent::__construct();
    }

}
