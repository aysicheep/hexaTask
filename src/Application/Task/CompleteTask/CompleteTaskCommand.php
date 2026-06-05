<?php
declare(strict_types=1);
namespace App\Application\Task\CompleteTask;


/**
 * Commande pour marquer une tâche comme terminée (COMPLETED).
 *
 * @property string $taskId UUID de la tâche à compléter.
 */
class CompleteTaskCommand
{
    public function __construct(public readonly string $taskId) {}
}