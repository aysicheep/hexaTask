<?php
declare(strict_types=1);
namespace App\Infrastructure\Doctrine\Type;
use App\Domain\Member\MemberId;
use App\Infrastructure\Doctrine\Type\Abstract\AbstractGuidType;
use Override;

final class MemberIdType extends AbstractGuidType 
{

    public const NAME = "member_id";

    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    protected function fromString(string $value): MemberId
    {
        return new MemberId($value);
    }
}