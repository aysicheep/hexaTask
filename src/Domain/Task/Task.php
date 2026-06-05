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
 * Agrégat représentant une tâche appartenant à un workspace.
 *
 * Une tâche naît avec le statut TODO et suit un cycle de vie strict :
 * TODO → IN_PROGRESS → COMPLETED. L'état COMPLETED est terminal.
 * Elle peut être assignée à un membre tant qu'elle n'est pas terminée.
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
     * Crée une nouvelle tâche dans un workspace et enregistre l'événement TaskCreated.
     *
     * @param TaskId $id            Identifiant unique de la tâche.
     * @param TaskTitle $title      Titre de la tâche (non vide, max 250 caractères).
     * @param WorkspaceId $workspaceId Workspace auquel appartient la tâche.
     */
    public static function create(TaskId $id, TaskTitle $title, WorkspaceId $workspaceId): self
    {
        $task = new self($id, $title, $workspaceId);
        $task->record(new TaskCreated($id, $workspaceId));
        return $task;
    }

    /**
     * Assigne la tâche à un membre.
     *
     * @param MemberId $memberId Identifiant du membre à qui assigner la tâche.
     * @throws TaskAlreadyClosedException Si la tâche est déjà au statut COMPLETED.
     */
    public function assign(MemberId $memberId): void
    {
        if ($this->status === TaskStatus::COMPLETED) {
            throw new TaskAlreadyClosedException("Il est impossible d'assigner une tache {$this->status->label()}");
        }
        $this->assignedTo = $memberId;
    }

    /**
     * Effectue une transition vers un nouveau statut et enregistre TaskStatusChanged.
     *
     * @param TaskStatus $newStatus Le statut cible.
     * @throws InvalidTaskTransitionException Si la transition est interdite par le cycle de vie.
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
     * Raccourci pour passer la tâche au statut COMPLETED.
     *
     * @throws InvalidTaskTransitionException Si la transition vers COMPLETED est interdite.
     */
    public function complete(): void
    {
        $this->changeStatus(TaskStatus::COMPLETED);
    }

    /** Retourne le statut courant de la tâche. */
    public function status(): TaskStatus
    {
        return $this->status;
    }

    /** Retourne l'identifiant unique de la tâche. */
    public function id(): TaskId
    {
        return $this->id;
    }

    /** Retourne le titre de la tâche. */
    public function title(): TaskTitle
    {
        return $this->title;
    }

    /** Retourne l'identifiant du workspace auquel appartient la tâche. */
    public function workspaceId(): WorkspaceId
    {
        return $this->workspaceId;
    }

    /**
     * Retourne l'identifiant du membre assigné à la tâche.
     *
     * @return MemberId|null null si la tâche n'est pas encore assignée.
     */
    public function assignedTo(): ?MemberId
    {
        return $this->assignedTo;
    }
}
