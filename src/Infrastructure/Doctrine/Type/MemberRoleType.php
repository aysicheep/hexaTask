<?php
declare(strict_types=1);
namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Member\MemberRole;
use App\Infrastructure\Doctrine\Type\Abstract\AbstractEnumType;
use Override;

final class MemberRoleType extends AbstractEnumType 
{

    public const NAME = "member_role";

    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    protected function fromString(string $value): MemberRole
    {
        return MemberRole::from($value);
    }
}