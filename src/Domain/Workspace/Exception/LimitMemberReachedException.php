<?php
declare(strict_types=1);
namespace App\Domain\Workspace\Exception;

/**
 * Levée lorsque la limite de 50 membres d'un workspace est atteinte.
 *
 * Aucun nouveau membre ne peut être ajouté tant que la limite n'est pas libérée.
 */
final class LimitMemberReachedException extends \DomainException
{
}