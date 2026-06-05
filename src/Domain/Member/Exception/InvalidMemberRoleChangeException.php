<?php
declare(strict_types=1);
namespace App\Domain\Member\Exception;

use DomainException;

/**
 * Levée lorsqu'une tentative de changement de rôle est invalide.
 *
 * Cas concret : tenter de modifier le rôle d'un membre OWNER,
 * qui est immuable par règle métier.
 */
final class InvalidMemberRoleChangeException extends DomainException {}