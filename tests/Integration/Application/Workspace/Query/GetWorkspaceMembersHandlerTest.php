<?php
declare(strict_types=1);
namespace Tests\Integration\Application\Workspace\Query;

use App\Application\Member\Query\MemberReadModel;
use App\Application\Workspace\Query\GetWorkspaceMembersHandler;
use App\Application\Workspace\Query\GetWorkspaceMembersQuery;
use App\Domain\Member\Member;
use App\Domain\Member\MemberId;
use App\Domain\Member\MemberRepositoryInterface;
use App\Domain\Member\MemberRole;
use App\Domain\Workspace\Workspace;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Workspace\WorkspaceName;
use App\Domain\Workspace\WorkspaceRepositoryInterface;
use Override;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Integration\InMemory\InMemoryMemberRepository;
use Tests\Integration\InMemory\InMemoryWorkspaceRepository;

#[CoversClass(GetWorkspaceMembersHandler::class)]
final class GetWorkspaceMembersHandlerTest extends TestCase{
    private InMemoryWorkspaceRepository $workspaceRepository;
    private InMemoryMemberRepository $memberRepository;
    private GetWorkspaceMembersQuery $query;
    private GetWorkspaceMembersHandler $handler;
    private WorkspaceId $workspaceId;

    #[Override]
    protected function setUp(): void
    {
        $this->workspaceRepository = new InMemoryWorkspaceRepository();
        $this->memberRepository = new InMemoryMemberRepository();
        $this->workspaceId = WorkspaceId ::generate();
        $this->query = new GetWorkspaceMembersQuery($this->workspaceId->value());
        $this->handler = new GetWorkspaceMembersHandler($this->workspaceRepository,$this->memberRepository);
    }
    

    private function createWorksapce() :Workspace {
        $memberId = MemberId::generate();
        $workspaceName = new WorkspaceName("test");
        return Workspace::create($this->workspaceId,$workspaceName,$memberId);
    }

    private function createMember() :Member {
        $memberId = MemberId::generate();
        return Member::create($memberId, MemberRole::MEMBER);
    }

    private function saveWorkspace(Workspace $workspace) :void {
        $this->workspaceRepository->save($workspace);
    }

    private function saveMember(Member $member) :void {
        $this->memberRepository->save($member);
    }

    public function testHandleReturnsMemberReadModels() :void {
        $workspace = $this->createWorksapce();
        $member = $this->createMember();
        $this->saveMember($member);
        $workspace->addMember($member->id());
        $this->saveWorkspace($workspace);
        $memberReadModels = ($this->handler)($this->query);
        $this->assertNotEmpty($memberReadModels);
        $this->assertContainsOnlyInstancesOf(MemberReadModel::class,$memberReadModels);
    }

}