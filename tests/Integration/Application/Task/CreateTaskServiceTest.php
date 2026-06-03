<?php 
declare(strict_types=1);
namespace Tests\Integration\Application\Task;

use App\Application\Task\CompleteTask\CompleteTaskCommand;
use App\Application\Task\CreateTask\CreateTaskCommand;
use App\Application\Task\CreateTask\CreateTaskService;
use App\Domain\Member\MemberId;
use App\Domain\Workspace\WorkspaceId;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Integration\InMemory\InMemoryTaskRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CreateTaskService::class)]
final class CreateTaskServiceTest extends TestCase
{
    public function testCreateTaskSuccessfully(){
        $inMemoryRepository = new InMemoryTaskRepository();
        $eventDispatcherInterface = $this->createStub(EventDispatcherInterface::class);
        $createTaskService = new CreateTaskService($inMemoryRepository, $eventDispatcherInterface);
        $workpaceId = WorkspaceId::generate()->value();
        $memberId = MemberId::generate()->value();
        $command = new CreateTaskCommand('task1',$workpaceId,$memberId);
        $workpaceId = new WorkspaceId($command->workspaceId);
        $createTaskService->execute($command);
        $this->assertCount(1,$inMemoryRepository->getAllByWorkspaceId($workpaceId));
    }
}