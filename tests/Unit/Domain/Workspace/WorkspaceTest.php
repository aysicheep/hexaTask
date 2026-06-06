<?php
declare(strict_types=1);

namespace Tests\Unit\Domain\Workspace;

use App\Domain\Workspace\WorkspaceId;
use App\Domain\Workspace\WorkspaceName;
use App\Domain\Member\MemberId;
use App\Domain\Workspace\Exception\LimitMemberReachedException;
use App\Domain\Workspace\Exception\MemberAlreadyExistException;
use App\Domain\Workspace\Workspace;
use Override;
use PHPUnit\Framework\TestCase;

final class WorkspaceTest extends TestCase {

    private WorkspaceId $workspaceId;
    private WorkspaceName $workspaceName;
    private MemberId $memberId;

    #[Override]
    protected function setUp(): void
    {
        $this->workspaceId = WorkspaceId::generate();
        $this->workspaceName = new WorkspaceName('test workspace');
        $this->memberId = MemberId::generate();
    }

    public function testCreate(): void 
    {
        $workspace = Workspace::create($this->workspaceId,$this->workspaceName,$this->memberId);
        $this->assertInstanceOf(Workspace::class,$workspace);
    }

    public function testAddMember(): void 
    {
        $workspace = Workspace::create($this->workspaceId,$this->workspaceName,$this->memberId);
        $newMemberId = MemberId::generate();
        $workspace->addMember($newMemberId);
        $memberIds = $workspace->memberIds();
        $this->assertContains($newMemberId,$memberIds);
    }

    public function testId() : void 
    {
        $workspace = Workspace::create($this->workspaceId,$this->workspaceName,$this->memberId);
        $this->assertTrue($workspace->id() === $this->workspaceId);
    }
    public function testName(): void 
    {   
        $workspace = Workspace::create($this->workspaceId,$this->workspaceName,$this->memberId);
        $this->assertSame($workspace->name()->value(),$this->workspaceName->value());
    }

    public function testOwnerId() : void 
    {
        $workspace = Workspace::create($this->workspaceId,$this->workspaceName,$this->memberId);
        $this->assertTrue($workspace->ownerId() === $this->memberId);
    }

    public function testMemberId(): void 
    {
        $workspace = Workspace::create($this->workspaceId,$this->workspaceName,$this->memberId);
        $this->assertNotEmpty($workspace->memberIds());
        $this->assertContainsOnlyInstancesOf(MemberId::class,$workspace->memberIds());
    }

    public function testLimitMemberReachedException() : void
    {
        $this->expectException(LimitMemberReachedException::class);
        $workspace = Workspace::create($this->workspaceId,$this->workspaceName,$this->memberId);
        $memberIds = array_map(
                fn() => MemberId::generate(),
                range(1, 50)
            ); 
        foreach ($memberIds as $memberId) {
            $workspace->addMember($memberId);
        }

    }

    public function testMemberAlreadyExistException() : void 
    {
        $this->expectException(MemberAlreadyExistException::class);
        $workspace = Workspace::create($this->workspaceId,$this->workspaceName,$this->memberId);
        $workspace->addMember($this->memberId);
    }
}