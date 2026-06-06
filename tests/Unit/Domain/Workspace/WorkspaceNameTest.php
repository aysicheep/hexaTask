<?php
declare(strict_types=1);

namespace Tests\Unit\Domain\Workspace;

use App\Domain\Workspace\Exception\EmptyWorkspaceNameException;
use App\Domain\Workspace\Exception\WorkspaceNameTooLongException;
use App\Domain\Workspace\WorkspaceName;
use PHPUnit\Framework\TestCase;

final class WorkspaceNameTest extends TestCase {

    public function testEmptyWorkspaceNameException() : void 
    {
        $this->expectException(EmptyWorkspaceNameException::class);
        new WorkspaceName('');
    }
    public function testWorkspaceNameTooLong() : void 
    {
        $this->expectException(WorkspaceNameTooLongException::class);
        new WorkspaceName(str_repeat('a',101));
    }
    public function testToString() : void 
    {
        $worspaceName = new WorkspaceName('test');
        $this->assertSame($worspaceName->value(),(string) $worspaceName);
    }

    public function testEquals() : void 
    {
        $worspaceName1 = new WorkspaceName('name1');
        $worspaceName2 = new WorkspaceName('name2');
        $this->assertFalse($worspaceName1->equals($worspaceName2));
    }
}