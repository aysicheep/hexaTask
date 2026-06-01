<?php
declare(strict_types=1);
namespace App\Application\Task\CompleteTask;

use App\Domain\Task\Exception\TaskNotFoundException;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\TaskStatus;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CompleteTaskService {
    public function __construct(
        private TaskRepositoryInterface $taskRepositoryInterface, 
        private EventDispatcherInterface $eventDispatcher)
    {
    }

    public function complete(CompleteTaskCommand $completeTaskCommand) :void
    {
        $taskId = new TaskId($completeTaskCommand->taskId);
        $task = $this->taskRepositoryInterface->findById($taskId);
        if($task === null){
            throw new TaskNotFoundException($completeTaskCommand->taskId);
        }
        $task->complete();
        $events = $task->releaseEvents();
        foreach($events as $event){
            $this->eventDispatcher->dispatch($event);
        }

    }
}