<?php 
declare(strict_types=1);
namespace App\Application\Task\Query;

use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Task\Task;

/**
 * Handler de la query GetTaskByWorkspaceQuery.
 *
 * Récupère toutes les tâches d'un workspace et les projette en TaskReadModel,
 * un objet plat adapté à la lecture (API, affichage).
 */
class GetTaskByWorkspaceHandler
{
    public function __construct(
        private TaskRepositoryInterface $taskRepositoryInterface
    ) {}

    /**
     * Retourne la liste des tâches du workspace sous forme de read models.
     *
     * @param GetTaskByWorkspaceQuery $getTaskByWorkspaceQuery Query contenant le workspaceId.
     * @return TaskReadModel[]
     */
    public function __invoke(GetTaskByWorkspaceQuery $getTaskByWorkspaceQuery): array
    {
        $workpaceId = new WorkspaceId($getTaskByWorkspaceQuery->workspaceId);
        $tasks = $this->taskRepositoryInterface->getAllByWorkspaceId($workpaceId);
        return array_map($this->toReadModel(...), $tasks);
    }

    /** Projette un agrégat Task en TaskReadModel. */
    private function toReadModel(Task $task): TaskReadModel
    {
        return new TaskReadModel(
            $task->id()->value(),
            $task->title()->value(),
            $task->status()->label(),
            $task->workspaceId()->value(),
            $task->assignedTo()?->value()
        );
    }
}