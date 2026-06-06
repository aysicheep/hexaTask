<?php   
declare(strict_types=1);

namespace Tests\Unit\Domain\Member;

use PHPUnit\Framework\TestCase;
use App\Domain\Member\MemberRole;
use PHPUnit\Framework\Attributes\DataProvider;

final class MemberRoleTest extends TestCase
{
    #[DataProvider('roles')]
    public function TestLabel(MemberRole $role, string $expected) : void 
    {
        $this->assertSame($role->label(),$expected);
    }

    public static function roles(): array
    {
        return [
            'owner'  => [MemberRole::OWNER,  'Propriétaire'],
            'admin'  => [MemberRole::ADMIN,  'Administrateur'],
            'member' => [MemberRole::MEMBER, 'Membre'],
        ];
    }

    #[DataProvider('canManageMembers')]
    public function testCanManageMembers(MemberRole $role, bool $expected): void
    {
        $this->assertSame($expected, $role->canManageMembers());
    }

    public static function canManageMembers(): array
    {
        return [
            'owner peut gérer' => [MemberRole::OWNER, true],
            'admin peut gérer' => [MemberRole::ADMIN, true],
            'member ne peut pas' => [MemberRole::MEMBER, false],
        ];
    }

    public function testMemberCannotDeleteWorkspace(): void
    {
        $this->assertFalse(MemberRole::MEMBER->canDeleteWorkspace());
    }
}