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
        if ($value === null) {
            return [];
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException(
                sprintf('Expected string from DB, got %s', get_debug_type($value))
            );
        }

        /** @var list<string> $decoded */
        $decoded = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        return array_map(static fn (string $id): MemberId => new MemberId($id), $decoded);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        if ($value === null || $value === []) {
            return '[]';
        }

        if (!is_array($value)) {
            throw new \InvalidArgumentException(
                sprintf('Expected array of MemberId, got %s', get_debug_type($value))
            );
        }

        return json_encode(
            array_map(static fn (MemberId $id): string => $id->value(), $value),
            JSON_THROW_ON_ERROR
        );
    }
}