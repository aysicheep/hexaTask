<?php
declare(strict_types=1);
namespace App\Domain\Shared\Workspace;
use Ramsey\Uuid\Uuid;
final readonly class WorkspaceId
{
    public function __construct(private string $value) {
        if(preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $value) !== 1) {
            throw new \InvalidArgumentException('Invalid UUID format');
        }
    }

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
        return $this->value;
    }

    public function equals(WorkspaceId $other): bool
    {
        return $this->value === $other->value;
    }
}