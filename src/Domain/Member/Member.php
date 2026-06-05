<?php

declare(strict_types=1);

namespace App\Domain\Member;

use App\Domain\Member\Event\MemberCreated;
use App\Domain\Shared\AggregateRoot;
use App\Domain\Member\Exception\InvalidMemberRoleChangeException;

/**
 * Agrégat représentant un utilisateur dans le système.
 *
 * Un membre possède un identifiant unique et un rôle déterminant ses droits
 * dans les workspaces auxquels il appartient. Le rôle OWNER ne peut jamais
 * être modifié une fois attribué.
 */
final class Member extends AggregateRoot
{
    private function __construct(
        private readonly MemberId $id,
        private MemberRole $role
    ) {
    }

    /**
     * Crée un nouveau membre et enregistre l'événement MemberCreated.
     *
     * @param MemberId $id   Identifiant unique du membre.
     * @param MemberRole $role Rôle initial du membre (OWNER, ADMIN ou MEMBER).
     */
    public static function create(MemberId $id, MemberRole $role): self
    {
        $member = new self($id, $role);
        $member->record(new MemberCreated($id));
        return $member;
    }

    /** Retourne l'identifiant unique du membre. */
    public function id(): MemberId
    {
        return $this->id;
    }

    /** Retourne le rôle courant du membre. */
    public function role(): MemberRole
    {
        return $this->role;
    }

    /**
     * Change le rôle du membre.
     *
     * @throws InvalidMemberRoleChangeException Si le membre est OWNER (rôle immuable).
     */
    public function changeRole(MemberRole $memberRole): void
    {
        if ($this->role === MemberRole::OWNER) {
            throw new InvalidMemberRoleChangeException("Impossible de changer role Owner");
        }
        $this->role = $memberRole;
    }
}
