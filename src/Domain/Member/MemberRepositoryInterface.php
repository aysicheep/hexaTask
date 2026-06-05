<?php
declare(strict_types=1);
namespace App\Domain\Member;

/**
 * Contrat de persistance pour l'agrégat Member.
 *
 * Les implémentations (Doctrine, InMemory) vivent dans les couches
 * Infrastructure et Tests — jamais dans le Domain.
 */
interface MemberRepositoryInterface
{
    /** Persiste un membre (création ou mise à jour). */
    public function save(Member $member): void;

    /**
     * Recherche un membre par son identifiant.
     *
     * @return Member|null null si aucun membre ne correspond à cet identifiant.
     */
    public function findById(MemberId $memberId): ?Member;
}