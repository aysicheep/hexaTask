<?php 
declare(strict_types=1);
namespace App\Application\Member\Query;

/**
 * Read model représentant un membre pour les besoins de lecture (queries).
 *
 * Objet plat sans logique métier, conçu pour être sérialisé ou affiché directement.
 *
 * @property string $memberId   UUID du membre.
 * @property string $memberRole Libellé lisible du rôle (ex: "Administrateur").
 */
class MemberReadModel
{
    public function __construct(
        public readonly string $memberId,
        public readonly string $memberRole
    ) {}
}