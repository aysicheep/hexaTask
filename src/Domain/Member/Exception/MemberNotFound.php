<?php
declare(strict_types=1);
namespace App\Domain\Member\Exception;

use DomainException;
use Throwable;
use Override;

final class MemberNotFound extends \DomainException
{
    public function __construct(string $memberId)
    {
        parent::__construct("Member id '{$memberId}' n'existe pas.");
    }
}