<?php
declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Persistence\Doctrine;

use App\Domain\Member\Member;
use App\Domain\Member\MemberId;
use Override;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Member\MemberRepositoryInterface;
use App\Domain\Member\MemberRole;
use App\Infrastructure\Persistence\Doctrine\DoctrineMemberRepository;

final class DoctrineMemberRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private MemberRepositoryInterface $memberRepository;
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $this->memberRepository = new DoctrineMemberRepository($this->em);
        $this->em->getConnection()->beginTransaction();
    }

    #[Override]
    protected function tearDown(): void
    {
        $connection = $this->em->getConnection();
        if ($connection->isTransactionActive()) {
            $connection->rollBack();
        }
        $this->em->clear();
        parent::tearDown();
    }

    public function testSave(): void
    {
        $memberId = MemberId::generate();
        $memberRole = MemberRole::MEMBER;
        $member = Member::create($memberId,$memberRole);
        $this->memberRepository->save($member);
        $this->em->clear();

        $savedMember = $this->memberRepository->findById($memberId);
        $this->assertNotNull($savedMember);
        $this->assertSame(
            $memberId->value(),
            $savedMember->id()->value()
        );
        $this->assertSame(
            $savedMember->role(),
            $memberRole
        );
    }
}