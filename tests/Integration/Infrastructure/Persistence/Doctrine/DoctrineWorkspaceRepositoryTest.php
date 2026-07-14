<?php
declare(strict_types=1);
namespace Tests\Integration\Infrastructure\Persistence\Doctrine;

use App\Domain\Member\MemberId;
use App\Domain\Workspace\Workspace;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Workspace\WorkspaceName;
use Override;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Workspace\WorkspaceRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\DoctrineWorkspaceRepository;

final class DoctrineWorkspaceRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private WorkspaceRepositoryInterface $workspaceRepository;
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $this->workspaceRepository = new DoctrineWorkspaceRepository($this->em);
        $this->em->getConnection()->beginTransaction();
    }

    #[Override]
    protected function tearDown(): void
    {
        $connection = $this->em->getConnection();
        if ($connection->isTransactionActive()) {
            $connection->rollBack();
        }
        $this->em->clear();
        parent::tearDown();
    }

    public function testSave(): void 
    {
        $workspaceId = WorkspaceId::generate();
        $workspaceName = new WorkspaceName("First workspace");
        $ownerId = MemberId::generate();
        $memberId1 = MemberId::generate();
        $memberId2 = MemberId::generate();
        $workspace = Workspace::create($workspaceId,$workspaceName,$ownerId);
        $workspace->addMember($memberId1);
        $workspace->addMember($memberId2);
        $this->workspaceRepository->save($workspace);
        $this->em->clear();
        $savedWorkspace = $this->workspaceRepository->findById($workspaceId);

        $this->assertNotNull($savedWorkspace);
        $this->assertSame(
            $workspaceId->value(),
            $savedWorkspace->id()->value()
        );
        $this->assertSame(
            $savedWorkspace->name()->value(),
            'First workspace'
        );

        $memberIds = $savedWorkspace->memberIds();
        $idsMember = array_map(
            static fn(MemberId $memberId): string => $memberId->value(), $memberIds
        );
        $this->assertCount(3,$idsMember);
        $this->assertContains($memberId1->value(), $idsMember);
        $this->assertContains($memberId2->value(), $idsMember);
        $this->assertContains($ownerId->value(), $idsMember);
    }

    public function testFindByIdReturnsNullWhenNotFound(): void
    {
            $workspaceId = WorkspaceId::generate();
            $this->assertNull($this->workspaceRepository->findById($workspaceId));
    }
}