<?php 
declare(strict_types=1);
namespace App\Application\Task\AssignTask;

use App\Domain\Member\Exception\MemberNotFound;
use App\Domain\Member\MemberId;
use App\Domain\Task\Exception\TaskAlreadyClosedException;
use App\Domain\Task\Exception\TaskNotFoundException;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\TaskStatus;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Service applicatif orchestrant l'assignation d'une tâche à un membre.
 *
 * Récupère la tâche, délègue la règle métier à l'agrégat Task
 * et dispatche les événements domaine enregistrés.
 */
class AssignTaskService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepositoryInterface,
        private EventDispatcherInterface $eventDispatcherInterface
    ) {}

    /**
     * Assigne la tâche identifiée dans la commande au membre indiqué.
     *
     * @param AssignTaskCommand $assignTaskCommand Données de la commande (taskId, memberId).
     * @throws TaskNotFoundException          Si aucune tâche ne correspond au taskId.
     * @throws TaskAlreadyClosedException     Si la tâche est déjà au statut COMPLETED.
     */
    public function assign(AssignTaskCommand $assignTaskCommand): void
    {
        $taskId = new TaskId($assignTaskCommand->taskId);
        $task = $this->taskRepositoryInterface->findById($taskId);
        if ($task === null) {
            throw new TaskNotFoundException($assignTaskCommand->taskId);
        }
        if($task->status() === TaskStatus::COMPLETED) {
            throw new TaskAlreadyClosedException("La tâche est terminée.");
        }
        $memberId = new MemberId($assignTaskCommand->memberId);
        $task->assign($memberId);
        $events = $task->releaseEvents();
        foreach ($events as $event) {
            $this->eventDispatcherInterface->dispatch($event);
        }
    }
}