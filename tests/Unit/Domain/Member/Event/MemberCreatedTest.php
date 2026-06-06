<?php
declare(strict_types=1);

namespace Tests\Unit\Domain\Member\Event;

use App\Domain\Member\Event\MemberCreated;
use App\Domain\Member\MemberId;
use PHPUnit\Framework\TestCase;

final class MemberCreatedTest extends TestCase 
{
    public function testCreate() : void 
    {
        $memberCreated = new MemberCreated(MemberId::generate());
        $this->assertInstanceOf(MemberCreated::class,$memberCreated);
    }
}