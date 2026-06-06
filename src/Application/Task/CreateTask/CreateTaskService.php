<?php
declare(strict_types=1);
namespace App\Application\Task\CreateTask;

use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Task\TaskTitle;
use App\Domain\Workspace\WorkspaceId;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Service applicatif orchestrant la création d'une tâche.
 *
 * Génère un identifiant UUID, hydrate les value objects, persiste l'agrégat
 * et dispatche les événements domaine enregistrés.
 */
class CreateTaskService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepositoryInterface,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    /**
     * Exécute la création d'une tâche.
     *
     * @param CreateTaskCommand $createCommand Données de la commande (titre, workspaceId, memberId optionnel).
     */
    public function execute(CreateTaskCommand $createCommand): void
    {
        $taskId = TaskId::generate();
        $taskTitle = TaskTitle::create($createCommand->taskTitle);
        $workpaceId = new WorkspaceId($createCommand->workspaceId);
        $task = Task::create($taskId, $taskTitle, $workpaceId);
        $this->taskRepositoryInterface->save($task);
        $events = $task->releaseEvents();
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}