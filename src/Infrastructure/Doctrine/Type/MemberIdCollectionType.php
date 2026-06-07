<?php
declare(strict_types=1);
namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Member\MemberId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class MemberIdCollectionType extends Type
{
    public const NAME = 'member_id_collection';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    /** @return MemberId[] */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): array
    {
        if ($value === null) return [];
        $decoded = json_decode($value, true);
        return array_map(fn(string $id) => new MemberId($id), $decoded);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        if ($value === null) return '[]';
        return json_encode(array_map(fn(MemberId $id) => $id->value(), $value));
    }
}