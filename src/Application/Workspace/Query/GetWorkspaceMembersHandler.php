<?php
declare(strict_types=1);

namespace App\Application\Workspace\Query;

use App\Application\Member\Query\MemberReadModel;
use App\Domain\Member\Member;
use App\Domain\Member\MemberId;
use App\Domain\Member\MemberRepositoryInterface;
use App\Domain\Workspace\Exception\WorkspaceNotFoundExeption;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Workspace\WorkspaceRepositoryInterface;

/**
 * Handler de la query GetWorkspaceMembersQuery.
 *
 * Charge le workspace, résout chaque MemberId en agrégat Member, puis projette
 * les résultats en MemberReadModel pour la lecture (API, affichage).
 * Les membres introuvables en base sont silencieusement ignorés (array_filter).
 */
class GetWorkspaceMembersHandler
{
    public function __construct(
        private WorkspaceRepositoryInterface $workspaceRepositoryInterface,
        private MemberRepositoryInterface $memberRepository
    ) {}

    /**
     * Retourne la liste des membres du workspace sous forme de read models.
     *
     * @param GetWorkspaceMembersQuery $query Query contenant le workspaceId.
     * @return MemberReadModel[]
     * @throws WorkspaceNotFoundExeption Si aucun workspace ne correspond au workspaceId.
     */
    public function __invoke(GetWorkspaceMembersQuery $query): array
    {
        $workspaceId = new WorkspaceId($query->workspaceId);
        $workspace = $this->workspaceRepositoryInterface->findById($workspaceId);
        if ($workspace === null) {
            throw new WorkspaceNotFoundExeption("Le workspace n'existe pas.");
        }
        $memberIds = $workspace->memberIds();
        $members = array_filter(
            array_map(fn(MemberId $memberId) => $this->memberRepository->findById($memberId), $memberIds),
            fn($member) => $member !== null
        );
        return array_map($this->toReadModel(...), $members);
    }

    /** Projette un agrégat Member en MemberReadModel. */
    private function toReadModel(Member $member): MemberReadModel
    {
        return new MemberReadModel(
            $member->id()->value(),
            $member->role()->label()
        );
    }
}