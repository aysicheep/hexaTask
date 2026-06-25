<?php
declare(strict_types=1);
namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Workspace\Workspace;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Workspace\WorkspaceRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Override;

class DoctrineWorkspaceRepository implements WorkspaceRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }
    #[Override]
    public function save(Workspace $workspace): void
    {
        $this->em->persist($workspace);
        $this->em->flush();  
    }
    #[Override]
    public function findById(WorkspaceId $workspaceId): ?Workspace
    {
        return $this->em->find(Workspace::class,$workspaceId);
    }
}