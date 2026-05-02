<?php
    declare(strict_types= 1);
    namespace App\Domain\Shared\Member;

    /**
     * MemberRole enum represents the different roles a workspace member can have.
     *
     * OWNER: full control (manage members, delete workspace)
     * ADMIN: can manage members
     * MEMBER: regular member with no management privileges
     */
    Enum MemberRole : string{
        case OWNER = 'owner';
        case ADMIN = 'admin'; 
        case MEMBER = 'member';


        public function label() : string {
            return match($this) {
                self::OWNER => "owner",
                self::ADMIN => "admin",
                self::MEMBER => "member",
            };
        }

        public function canManageMembers() : bool {
            return match($this){
                self::OWNER , self::ADMIN => true,
                self::MEMBER => false,   
            };
        }

        public function canDeleteWorkpace() : bool {
            return $this === self::OWNER; 
        }

    }
?>