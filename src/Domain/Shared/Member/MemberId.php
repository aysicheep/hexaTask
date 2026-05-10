<?php
declare(strict_types=1);
namespace App\Domain\Shared\Member;
use Ramsey\Uuid\Uuid;
final readonly class MemberId
{
    public function __construct(private string $value) {}

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        throw new \Exception('Not implemented');
    }
}