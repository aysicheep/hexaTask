<?php 
declare(strict_types=1);

namespace Tests\Unit\Domain\Task;

use App\Domain\Member\MemberId;
use App\Domain\Task\Exception\InvalidTaskTransitionException;
use App\Domain\Task\Exception\TaskAlreadyClosedException;
use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskStatus;
use App\Domain\Task\TaskTitle;
use App\Domain\Workspace\WorkspaceId;
use Override;
use PHPUnit\Framework\TestCase;

final class TaskTest extends TestCase {
    
    private TaskId $taskId;
    private TaskTitle $taskTitle;
    private WorkspaceId $workspaceId;
    private MemberId $memberId;
    #[Override]
    protected function setUp(): void
    {
        $this->taskId = TaskId::generate();
        $this->taskTitle = TaskTitle::create('test');
        $this->workspaceId = WorkspaceId::generate();
        $this->memberId = MemberId::generate();
        
    }
    public function testCreate() :void{
        $task = Task::create($this->taskId,$this->taskTitle,$this->workspaceId);
        $this->assertInstanceOf(Task::class,$task);
    }

    public function testAssign() :void{
        $task = Task::create($this->taskId,$this->taskTitle,$this->workspaceId);
        $task->assign($this->memberId);
        $this->assertSame($task->assignedTo()->value(),$this->memberId->value());
    }

    public function testChangeStatus() :void {
        $task = Task::create($this->taskId,$this->taskTitle,$this->workspaceId);
        $task->changeStatus(TaskStatus::IN_PROGRESS);
        $this->assertSame($task->status(),TaskStatus::IN_PROGRESS);
    }

    public function testComplete() :void{
        $task = Task::create($this->taskId,$this->taskTitle,$this->workspaceId);
        $task->complete();
        $this->assertTrue($task->status() === TaskStatus::COMPLETED);
    }
    
    public function testTaskAlreadyClosedException() :void{
        $this->expectException(TaskAlreadyClosedException::class);
        $task = Task::create($this->taskId,$this->taskTitle,$this->workspaceId);
        $task->complete();
        $task->assign($this->memberId);
    }

    public function testInvalidtaskTransitionExeption():void {
        $this->expectException(InvalidTaskTransitionException::class);
        $task = Task::create($this->taskId,$this->taskTitle,$this->workspaceId);
        $task->complete();
        $task->changeStatus(TaskStatus::IN_PROGRESS);
    }
}