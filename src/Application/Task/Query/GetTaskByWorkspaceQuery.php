<?php 
declare(strict_types=1);
namespace App\Application\Task\Query;

/**
 * Query pour récupérer toutes les tâches d'un workspace donné.
 *
 * @property string $workspaceId UUID du workspace dont on veut lister les tâches.
 */
class GetTaskByWorkspaceQuery
{
    public function __construct(public readonly string $workspaceId) {}
}