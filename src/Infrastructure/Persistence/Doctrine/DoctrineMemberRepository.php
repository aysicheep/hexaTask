<?php 
declare(strict_types=1);
namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Member\Member;
use App\Domain\Member\MemberId;
use App\Domain\Member\MemberRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Override;

class DoctrineMemberRepository implements MemberRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }
    #[Override]
    public function save(Member $member): void
    {
        $this->em->persist($member);
        $this->em->flush();
    }
    #[Override]
    public function findById(MemberId $memberId): ?Member
    {
        return $this->em->find(Member::class,$memberId->value());
    }
}