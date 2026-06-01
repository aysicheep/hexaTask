<?php 
declare(strict_types=1);
namespace App\Application\Task\AssignTask;

use App\Domain\Member\MemberId;
use App\Domain\Task\TaskId;

class AssignTaskCommand {
    public function __construct(
        public readonly string $taskId,
        public readonly string $memberId) 
    {}
}