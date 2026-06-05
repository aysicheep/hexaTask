<?php 
declare(strict_types= 1);
namespace App\Domain\Task\Exception;
use DomainException;
/**
 * Levée lorsqu'une opération est tentée sur une tâche déjà terminée (COMPLETED).
 *
 * Exemple : tenter d'assigner un membre à une tâche dont le statut est COMPLETED.
 */
final class TaskAlreadyClosedException extends DomainException {}