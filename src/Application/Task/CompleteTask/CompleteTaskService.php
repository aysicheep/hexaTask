<?php
declare(strict_types=1);
namespace App\Application\Task\CompleteTask;

use App\Domain\Task\Exception\TaskNotFoundException;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\TaskStatus;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Service applicatif orchestrant la complétion d'une tâche.
 *
 * Récupère la tâche, délègue la règle métier à l'agrégat Task
 * et dispatche les événements domaine enregistrés.
 */
class CompleteTaskService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepositoryInterface,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    /**
     * Passe la tâche identifiée dans la commande au statut COMPLETED.
     *
     * @param CompleteTaskCommand $completeTaskCommand Données de la commande (taskId).
     * @throws TaskNotFoundException          Si aucune tâche ne correspond au taskId.
     * @throws InvalidTaskTransitionException Si la transition vers COMPLETED est interdite.
     */
    public function complete(CompleteTaskCommand $completeTaskCommand): void
    {
        $taskId = new TaskId($completeTaskCommand->taskId);
        $task = $this->taskRepositoryInterface->findById($taskId);
        if ($task === null) {
            throw new TaskNotFoundException($completeTaskCommand->taskId);
        }
        $task->complete();
        $events = $task->releaseEvents();
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}