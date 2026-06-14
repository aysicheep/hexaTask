<?php   
declare(strict_types=1);
namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Task\Task;
use App\Domain\Task\TaskId;
use App\Domain\Task\TaskRepositoryInterface;
use App\Domain\Workspace\WorkspaceId;
use Doctrine\ORM\EntityManagerInterface;
use Override;

class DoctrineTaskRepository implements TaskRepositoryInterface
{
    
    public function __construct(private EntityManagerInterface $em)
    {
    }
    #[Override]
    public function save(Task $task): void
    {
        $this->em->persist($task);
        $this->em->flush();
    }

    #[Override]
    public function findById(TaskId $taskId): ?Task
    {
        return $this->em->find(Task::class,$taskId);
    }

    #[Override]
    public function getAllByWorkspaceId(WorkspaceId $workspaceId): array
    {
        return $this->em->getRepository(Task::class)->findBy(['workspaceId'=>$workspaceId]);
    }
}