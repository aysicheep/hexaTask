<?php
declare(strict_types=1);
namespace App\Application\Workspace\CreateWorkspace;

use App\Domain\Member\MemberId;
use App\Domain\Workspace\Workspace;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Workspace\WorkspaceName;
use App\Domain\Workspace\WorkspaceRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateWorkspaceService 
{
        public function __construct(private WorkspaceRepositoryInterface $workspaceRepositoryInterface,
        private EventDispatcherInterface $eventDispatcherInterface)
        {
        }

        public function create(CreateWorkspaceCommand $createWorkspaceCommand):void 
        {
            $workspaceId = WorkspaceId::generate();
            $workspaceName = new WorkspaceName($createWorkspaceCommand->workspaceName);
            $memberId = new MemberId($createWorkspaceCommand->memberId);
            $workspace = Workspace::create($workspaceId,$workspaceName,$memberId);
            $this->workspaceRepositoryInterface->save($workspace);
            $events = $workspace->releaseEvents();

            foreach($events as $event){
                $this->eventDispatcherInterface->dispatch($event);
            }
            
        }
}