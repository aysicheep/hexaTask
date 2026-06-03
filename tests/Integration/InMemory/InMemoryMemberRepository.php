<?php 
declare(strict_types=1);
namespace Tests\Integration\InMemory;
use App\Domain\Member\Member;
use App\Domain\Member\MemberId;
use App\Domain\Member\MemberRepositoryInterface;

final class InMemoryMemberRepository implements MemberRepositoryInterface{

    /** @var Member[] */
    private array $members = [];
    public function save(Member $member) : void {
        $this->members[$member->id()->value()] = $member;
    }

    public function findById(MemberId $memberId) :?Member {
        return $this->members[$memberId->value()] ?? null;
    }
}