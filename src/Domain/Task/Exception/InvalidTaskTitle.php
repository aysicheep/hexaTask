<?php 
declare(strict_types= 1);
namespace App\Domain\Task\Exception;
use DomainException;
/**
 * Levée lorsque le titre d'une tâche ne respecte pas les contraintes métier.
 *
 * Cas couverts : titre vide ou dépassant 250 caractères.
 */
final class InvalidTaskTitle extends DomainException {}