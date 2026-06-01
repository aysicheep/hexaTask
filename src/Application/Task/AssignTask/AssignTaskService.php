<?php 
declare(strict_types=1);
namespace App\Application\Task\AssignTask;

use App\Domain\Member\Exception\MemberNotFound;
use App\Domain\Member\MemberId;
use App\Domain\Task\Exception\TaskNotFoundException;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AssignTaskService 
{
    public function __construct(
       private TaskRepositoryInterface $taskRepositoryInterface,
       private EventDispatcherInterface $eventDispatcherInterface)
    {
    }

    public function assign(AssignTaskCommand $assignTaskCommand) :void
    {
        $taskId = new TaskId($assignTaskCommand->taskId);
        $task = $this->taskRepositoryInterface->findById($taskId);
        if($task === null){
            throw new TaskNotFoundException($assignTaskCommand->taskId);
        }
        $memberId = new MemberId($assignTaskCommand->memberId);
        $task->assign($memberId);
        $events = $task->releaseEvents();
        foreach($events as $event){
            $this->eventDispatcherInterface->dispatch($event);
        }
    }

    
}