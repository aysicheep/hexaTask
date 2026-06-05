<?php 
declare(strict_types=1);
namespace App\Application\Task\AssignTask;

use App\Domain\Member\MemberId;
use App\Domain\Task\TaskId;

/**
 * Commande pour assigner une tâche à un membre.
 *
 * @property string $taskId   UUID de la tâche à assigner.
 * @property string $memberId UUID du membre à qui assigner la tâche.
 */
class AssignTaskCommand
{
    public function __construct(
        public readonly string $taskId,
        public readonly string $memberId
    ) {}
}