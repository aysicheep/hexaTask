<?php
declare(strict_types=1);
namespace Tests\Integration\Application\Task;

use App\Application\Task\AssignTask\AssignTaskCommand;
use PHPUnit\Framework\TestCase;
use Tests\Integration\InMemory\InMemoryTaskRepository;
use App\Application\Task\AssignTask\AssignTaskService;
use App\Domain\Member\MemberId;
use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskTitle;
use App\Domain\Workspace\WorkspaceId;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Domain\Task\Exception\TaskNotFoundException;

class AssignTaskServiceTest extends TestCase {
    private InMemoryTaskRepository $inMemoryTaskRepository;
    private AssignTaskService $assigntaskService;

    protected function setUp(): void
    {
        $this->inMemoryTaskRepository = new InMemoryTaskRepository();
        $this->assigntaskService = new AssignTaskService($this->inMemoryTaskRepository,$this->createStub(EventDispatcherInterface::class));
    }

    public function testAssignTaskSuccefully() :void{
        $taskId = TaskId::generate();
        $memberId = MemberId::generate();
        $workspaceId = WorkspaceId::generate();
        $taskTitle = TaskTitle::create('tasktest');
        $task = Task::create($taskId,$taskTitle,$workspaceId);  
        $this->inMemoryTaskRepository->save($task);
        $command =  new AssignTaskCommand($taskId->value(),$memberId->value());
        $this->assigntaskService->assign($command);
        $this->assertSame($this->inMemoryTaskRepository->findById($taskId)->assignedTo()->value(),$memberId->value());
    }

    public function testAssignTaskThrowsTaskNotFoundExeption():void{
        $this->expectException(TaskNotFoundException::class);
        $taskId = TaskId::generate();
        $memberId = MemberId::generate();
        $workspaceId = WorkspaceId::generate();
        $taskTitle = TaskTitle::create('tasktest');
        $task = Task::create($taskId,$taskTitle,$workspaceId);
        $command =  new AssignTaskCommand($taskId->value(),$memberId->value());
        $this->assigntaskService->assign($command);
        $taskSearchedFor = $this->inMemoryTaskRepository->findById($taskId);
    }


}