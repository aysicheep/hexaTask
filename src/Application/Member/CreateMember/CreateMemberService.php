<?php
declare(strict_types=1);
namespace App\Application\Member\CreateMember;

use App\Domain\Member\Member;
use App\Domain\Member\MemberId;
use App\Domain\Member\MemberRepositoryInterface;
use App\Domain\Member\MemberRole;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Service applicatif orchestrant la création d'un membre.
 *
 * Génère un identifiant UUID, hydrate les value objects, persiste l'agrégat
 * et dispatche les événements domaine enregistrés.
 */
class CreateMemberService
{
    public function __construct(
        private MemberRepositoryInterface $memberRepositoryInterface,
        private EventDispatcherInterface $eventDispatcherInterface
    ) {}

    /**
     * Exécute la création d'un membre.
     *
     * @param CreateMemberCommand $createMemberCommand Données de la commande (rôle du membre).
     */
    public function create(CreateMemberCommand $createMemberCommand): void
    {
        $memberId = MemberId::generate();
        $memberRole = MemberRole::from($createMemberCommand->memberRole);
        $member = Member::create($memberId, $memberRole);
        $this->memberRepositoryInterface->save($member);
        $events = $member->releaseEvents();
        foreach ($events as $event) {
            $this->eventDispatcherInterface->dispatch($event);
        }
    }
}