<?php
declare(strict_types=1);
namespace App\Application\Member\CreateMember;

use App\Domain\Member\Member;
use App\Domain\Member\MemberId;
use App\Domain\Member\MemberRepositoryInterface;
use App\Domain\Member\MemberRole;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateMemberService {
    public function __construct(private MemberRepositoryInterface $memberRepositoryInterface,
    private EventDispatcherInterface $eventDispatcherInterface)
    {

    }

    public function create(CreateMemberCommand $createMemberCommand) :void {
        $memberId = MemberId::generate();
        $memberRole = MemberRole::from($createMemberCommand->memberRole);
        $member = Member::create($memberId,$memberRole);
        $this->memberRepositoryInterface->save($member);
        $events = $member->releaseEvents();
        foreach($events as $event){
            $this->eventDispatcherInterface->dispatch($event);
        }
    }
}