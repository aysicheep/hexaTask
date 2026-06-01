<?php
declare(strict_types=1);
namespace App\Application\Member\CreateMember;

class CreateMemberCommand {
    public function __construct(public readonly string $memberRole){}
}