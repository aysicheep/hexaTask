<?php
declare(strict_types=1);
namespace App\Domain\Member\Exception;

use DomainException;
use Throwable;
use Override;

/**
 * Levée lorsqu'un membre est introuvable en base de données.
 *
 * Le message embarque l'identifiant recherché pour faciliter le diagnostic.
 */
final class MemberNotFound extends \DomainException
{
    public function __construct(string $memberId)
    {
        parent::__construct("Member id '{$memberId}' n'existe pas.");
    }
}