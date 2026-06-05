<?php

declare(strict_types=1);

namespace App\Domain\Member;

/**
 * MemberRole enum represents the different roles a workspace member can have.
 *
 * OWNER: full control (manage members, delete workspace)
 * ADMIN: can manage members
 * MEMBER: regular member with no management privileges
 */
enum MemberRole: string
{
    case OWNER = 'owner';
    case ADMIN = 'admin';
    case MEMBER = 'member';


    /** Returns the human-readable label for the role. */
    public function label(): string
    {
        return match ($this) {
            self::OWNER => "Propietaire",
            self::ADMIN => "Administrateur",
            self::MEMBER => "Membre",
        };
    }

    /** Returns true if this role can add or remove workspace members. */
    public function canManageMembers(): bool
    {
        return match ($this) {
            self::OWNER , self::ADMIN => true,
            self::MEMBER => false,
        };
    }

    /** Returns true if this role can delete the workspace (OWNER only). */
    public function canDeleteWorkspace(): bool
    {
        return $this === self::OWNER;
    }

}
