<?php 
declare(strict_types=1);
namespace App\Application\Workspace\Query;

/**
 * Query pour récupérer tous les membres d'un workspace donné.
 *
 * @property string $workspaceId UUID du workspace dont on veut lister les membres.
 */
class GetWorkspaceMembersQuery
{
    public function __construct(public readonly string $workspaceId) {}
}