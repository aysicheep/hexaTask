<?php
declare(strict_types=1);
namespace App\Application\Member\CreateMember;

/**
 * Commande pour créer un nouveau membre.
 *
 * @property string $memberRole Rôle du membre à créer (valeur de l'enum MemberRole : 'owner', 'admin', 'member').
 */
class CreateMemberCommand
{
    public function __construct(public readonly string $memberRole) {}
}