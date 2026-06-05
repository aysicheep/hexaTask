<?php

declare(strict_types=1);

namespace App\Domain\Workspace;

use App\Domain\Shared\AggregateRoot;
use App\Domain\Member\MemberId;
use App\Domain\Workspace\Event\WorkspaceCreated;
use App\Domain\Workspace\Exception\LimitMemberReachedException;
use App\Domain\Workspace\Exception\MemberAlreadyExistException;

final class Workspace extends AggregateRoot
{
    /** @var MemberId[] */
    private array $memberIds = [];
    private const MAX_MEMBERS = 50;
    private function __construct(
        private WorkspaceId $id,
        private WorkspaceName $name,
        private readonly MemberId $ownerId
    ) {}

    public static function create(WorkspaceId $id, WorkspaceName $name, MemberId $ownerId): self
    {
        $ws = new Workspace($id, $name, $ownerId);
        $ws->memberIds[] = $ownerId;
        $ws->record(new WorkspaceCreated($id, $ownerId));
        return $ws;
    }

    public function addMember(MemberId $memberId): void
    {
        if (count($this->memberIds) >= self::MAX_MEMBERS) {
            throw new LimitMemberReachedException('Workspace member limit reached');
        }
        if (in_array($memberId->value(), array_map(fn($m) => $m->value(),$this->memberIds))) {
            throw new MemberAlreadyExistException('Member already in workspace');
        }

        $this->memberIds[] = $memberId;
    }

    public function id(): WorkspaceId
    {
        return $this->id;
    }

    public function name(): WorkspaceName
    {
        return $this->name;
    }

    public function ownerId(): MemberId
    {
        return $this->ownerId;
    }

    /** @return MemberId[] */
    public function memberIds():array
    {return $this->memberIds();}
}
