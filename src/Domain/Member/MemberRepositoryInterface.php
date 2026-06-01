<?php
declare(strict_types=1);
namespace App\Domain\Member;

interface MemberRepositoryInterface {
    public function save(Member $member) : void;
    public function findById(MemberId $memberId) : ?Member;
}