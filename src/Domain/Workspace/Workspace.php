<?php

declare(strict_types=1);

namespace App\Domain\Workspace;

use App\Domain\Shared\AggregateRoot;
use App\Domain\Member\MemberId;
use App\Domain\Workspace\Event\WorkspaceCreated;
use App\Domain\Workspace\Exception\LimitMemberReachedException;
use App\Domain\Workspace\Exception\MemberAlreadyExistException;

/**
 * Agrégat représentant un espace de travail collaboratif.
 *
 * Un workspace est créé par un propriétaire (OWNER) qui en devient
 * automatiquement le premier membre. Il peut accueillir jusqu'à 50 membres.
 * Toute tentative d'ajout au-delà de cette limite ou d'un membre déjà présent
 * lève une exception métier.
 */
final class Workspace extends AggregateRoot
{
    /** @var MemberId[] Liste des identifiants des membres du workspace. */
    private array $memberIds = [];

    /** Nombre maximum de membres autorisés dans un workspace. */
    private const MAX_MEMBERS = 50;

    private function __construct(
        private WorkspaceId $id,
        private WorkspaceName $name,
        private readonly MemberId $ownerId
    ) {}

    /**
     * Crée un nouveau workspace, ajoute le propriétaire comme premier membre
     * et enregistre l'événement WorkspaceCreated.
     *
     * @param WorkspaceId $id      Identifiant unique du workspace.
     * @param WorkspaceName $name  Nom du workspace (non vide, max 100 caractères).
     * @param MemberId $ownerId    Identifiant du membre propriétaire.
     */
    public static function create(WorkspaceId $id, WorkspaceName $name, MemberId $ownerId): self
    {
        $ws = new Workspace($id, $name, $ownerId);
        $ws->memberIds[] = $ownerId;
        $ws->record(new WorkspaceCreated($id, $ownerId));
        return $ws;
    }

    /**
     * Ajoute un membre au workspace.
     *
     * @param MemberId $memberId Identifiant du membre à ajouter.
     * @throws LimitMemberReachedException  Si le workspace compte déjà 50 membres.
     * @throws MemberAlreadyExistException  Si le membre est déjà présent dans le workspace.
     */
    public function addMember(MemberId $memberId): void
    {
        if (count($this->memberIds) >= self::MAX_MEMBERS) {
            throw new LimitMemberReachedException('Workspace member limit reached');
        }
        if (in_array($memberId->value(), array_map(fn($m) => $m->value(), $this->memberIds))) {
            throw new MemberAlreadyExistException('Member already in workspace');
        }

        $this->memberIds[] = $memberId;
    }

    /** Retourne l'identifiant unique du workspace. */
    public function id(): WorkspaceId
    {
        return $this->id;
    }

    /** Retourne le nom du workspace. */
    public function name(): WorkspaceName
    {
        return $this->name;
    }

    /** Retourne l'identifiant du propriétaire du workspace. */
    public function ownerId(): MemberId
    {
        return $this->ownerId;
    }

    /**
     * Retourne la liste des identifiants de tous les membres du workspace.
     *
     * @return MemberId[]
     */
    public function memberIds(): array
    {
        return $this->memberIds;
    }
}
