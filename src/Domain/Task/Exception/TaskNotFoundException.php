<?php 
declare(strict_types= 1);
namespace App\Domain\Task\Exception;
use DomainException;
/**
 * Levée lorsqu'une tâche est introuvable via son identifiant.
 *
 * Le message embarque l'identifiant recherché pour faciliter le diagnostic.
 */
final class TaskNotFoundException extends DomainException
{
    public function __construct(string $taskId)
    {
        parent::__construct("Task '{$taskId}' not found.");
    }
}