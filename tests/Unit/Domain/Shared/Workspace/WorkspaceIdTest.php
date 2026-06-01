<?php 
declare(strict_types=1);
namespace Tests\Unit\Domain\Shared\Workspace;
use App\Domain\Shared\Workspace\WorkspaceId;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\App\Domain\Shared\Workspace\WorkspaceId::class)]
final class WorkspaceIdTest extends TestCase
{
    public function testGenerate(): void
    {
            $workspaceId = WorkspaceId::generate();
            $this->assertInstanceOf(WorkspaceId::class, $workspaceId);
            $this->assertMatchesRegularExpression('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $workspaceId->value());   
    }

    public function testEquals(): void
    {
        $workspaceId1 = WorkspaceId::generate();
        $workspaceId2 = new WorkspaceId($workspaceId1->value());
        $workspaceId3 = WorkspaceId::generate();
        $this->assertTrue($workspaceId1->equals($workspaceId2));
        $this->assertFalse($workspaceId1->equals($workspaceId3));
    }
}
?>