<?php
declare(strict_types=1);
namespace App\Domain\Workspace\Exception;

/**
 * Levée lorsqu'un membre est ajouté à un workspace auquel il appartient déjà.
 */
final class MemberAlreadyExistException extends \DomainException {}