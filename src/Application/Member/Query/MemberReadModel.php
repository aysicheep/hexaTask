<?php 
declare(strict_types=1);
namespace App\Application\Member\Query;

class MemberReadModel {
    public function __construct(public readonly string $memberId, public readonly string $memberRole)
    {      
    }
}