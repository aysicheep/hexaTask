<?php 
    declare(strict_types= 1);
    namespace Tests\Unit\Domain\Member;

    use App\Domain\Member\MemberId;
    use PHPUnit\Framework\Attributes\CoversClass;
    use PHPUnit\Framework\TestCase;

    #[CoversClass(MemberId::class)]
    final class MemberIdTest extends TestCase {

        public function testGenerate(): void {
            $member = MemberId::generate();
            $this->assertInstanceOf(MemberId::class, $member);
            $this->assertMatchesRegularExpression('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $member->value());
        }

        public function testEquals(): void {
            $memberId1 = MemberId::generate();
            $memberId2 = new MemberId($memberId1->value());
            $memberId3 = MemberId::generate();
            $this->assertTrue($memberId1->equals($memberId2));
            $this->assertFalse($memberId2->equals($memberId3));
        }
    }