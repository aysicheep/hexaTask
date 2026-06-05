<?php 
declare (strict_types= 1);
namespace App\Domain\Task\Exception;

use DomainException;

/**
 * Levée lorsqu'une transition de statut est interdite par le cycle de vie d'une tâche.
 *
 * Exemple : tenter de repasser une tâche COMPLETED en TODO.
 * Consulter TaskStatus::canTransitionTo() pour les transitions autorisées.
 */
final class InvalidTaskTransitionException extends DomainException {}