<?php

declare(strict_types=1);

namespace App\Domain\Member\Event;

use App\Domain\Shared\DomainEvent;
use App\Domain\Member\MemberId;
use App\Domain\Member\MemberRole;

/**
 * Événement émis lorsqu'un nouveau membre est créé dans le système.
 *
 * @property MemberId $memberId Identifiant du membre nouvellement créé.
 */
final class MemberCreated extends DomainEvent
{
    public function __construct(public readonly MemberId $memberId)
    {
        parent::__construct();
    }
}
