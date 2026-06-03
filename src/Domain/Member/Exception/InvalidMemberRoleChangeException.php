<?php
declare(strict_types=1);
namespace App\Domain\Member\Exception;

use DomainException;

final class InvalidMemberRoleChangeException extends DomainException {}