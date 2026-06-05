<?php 
declare(strict_types=1);

namespace App\Domain\Workspace\Exception;

use DomainException;

/**
 * Levée lorsqu'un workspace est introuvable via son identifiant.
 */
final class WorkspaceNotFoundExeption extends DomainException {}