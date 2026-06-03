<?php 
declare(strict_types=1);
namespace Tests\Unit\Domain\Member;

use App\Domain\Member\Exception\InvalidMemberRoleChangeException;
use App\Domain\Member\Member;
use App\Domain\Member\MemberId;
use App\Domain\Member\MemberRole;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Member::class)]
final class MemberTest extends TestCase
{

    public function testCreateMember():void{
        $memberId = MemberId::generate();
        $memberRole = MemberRole::MEMBER;
        $member = Member::create($memberId,$memberRole);
        $this->assertInstanceOf(Member::class,$member);
    }
    public function testChangeMemberRoleSuccess():void{
        $member = Member::create(MemberId::generate(),MemberRole::MEMBER);
        $member->changeRole(MemberRole::ADMIN);
        $this->assertSame($member->role(),MemberRole::ADMIN);
    }
    public function testChangeMemberRoleThrowExcepetion() :void {
        $this->expectException(InvalidMemberRoleChangeException::class);
        $member = Member::create(MemberId::generate(),MemberRole::OWNER);
        $member->changeRole(MemberRole::ADMIN);
    }
}