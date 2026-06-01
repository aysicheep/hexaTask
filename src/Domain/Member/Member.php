<?php

declare(strict_types=1);

namespace App\Domain\Member;

use App\Domain\Member\Event\MemberCreated;
use App\Domain\Shared\AggregateRoot;

/**
 * Summary of Member
 */
final class Member extends AggregateRoot
{
    private MemberId $id;
    private MemberRole $role;
    public function __construct(
        MemberId $id,
        MemberRole $role
    ) {
        $this->id = $id;
        $this->role = $role;

    }
    /**
     * Summary of create
     * @param MemberId $id
     * @param MemberRole $role
     * @return Member
     */
    public static function create(MemberId $id, MemberRole $role): self
    {
        $member = new self($id, $role);
        $member->record(new MemberCreated($id));
        return $member;
    }
    /**
     * Summary of id
     * @return MemberId
     */
    public function id(): MemberId
    {
        return $this->id;
    }
    /**
     * Summary of role
     * @return MemberRole
     */
    public function role(): MemberRole
    {
        return $this->role;
    }
}
