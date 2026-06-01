<?php

declare(strict_types=1);

namespace App\Domain\Task;
use App\Domain\Member\MemberId;
use App\Domain\Shared\AggregateRoot;
use App\Domain\Workspace\WorkspaceId;
use App\Domain\Task\Event\TaskStatusChanged;
use App\Domain\Task\Event\TaskCreated;
use App\Domain\Task\Exception\TaskAlreadyClosedException;
use App\Domain\Task\Exception\InvalidTaskTransitionException;



/**
 * Summary of Task
 */
final class Task extends AggregateRoot
{
    private function __construct(
        private readonly TaskId $id,
        private TaskTitle $title,
        private readonly WorkspaceId $workspaceId,
        private TaskStatus $status = TaskStatus::TODO,
        private ?MemberId $assignedTo = null
    ) {}

    /**
     * Summary of create
     * @param TaskId $id
     * @param TaskTitle $title
     * @param WorkspaceId $workspaceId
     * @return Task
     */
    public static function create(TaskId $id, TaskTitle $title, WorkspaceId $workspaceId): self
    {
        $task = new self($id, $title, $workspaceId);
        $task->record(new TaskCreated($id, $workspaceId));
        return $task;
    }

    /**
     * Assign this task to a member.
     * A task can be assigned only if not completed
     * @param MemberId $memberId
     ** @throws TaskAlreadyClosedException
     */
    public function assign(MemberId $memberId): void
    {
        if($this->status === TaskStatus::COMPLETED ) {
            throw new TaskAlreadyClosedException("Il est impossible d'assigner une tache {$this->status->label()}");
        }
        $this->assignedTo = $memberId;
    }

    /**
     * Change status of a Task
     * @param TaskStatus $newStatus
     ** @throws InvalidTaskTransitionException
     * @return void
     */
    public function changeStatus(TaskStatus $newStatus): void
    {
        if (!$this->status->canTransitionTo($newStatus)) {
            throw new InvalidTaskTransitionException(
                "Il est impossible de passer de {$this->status->value} to {$newStatus->value}"
            );
        }

        $this->status = $newStatus;
        $this->record(new TaskStatusChanged($this->id, $newStatus));
    }

    /**
     * Summary of complete
     * @return void
     */
    public function complete(): void
    {
        $this->changeStatus(TaskStatus::COMPLETED);
    }

    /**
     * Summary of status
     * @return TaskStatus
     */
    public function status(): TaskStatus
    {
        return $this->status;
    }
    /**
     * Summary of id
     * @return TaskId
     */
    public function id(): TaskId
    {
        return $this->id;
    }

    /**
     * Summary of title
     * @return TaskTitle
     */
    public function title(): TaskTitle
    {
        return $this->title;
    }

    /**
     * Summary of workspaceId
     * @return WorkspaceId
     */
    public function workspaceId(): WorkspaceId
    {
        return $this->workspaceId;
    }

    /**
     * Summary of assignedTo
     * @return MemberId|null
     */
    public function assignedTo(): ?MemberId
    {
        return $this->assignedTo;
    }

}
