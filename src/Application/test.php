<?php

declare(strict_types=1);

namespace App\Application;

require __DIR__ . '/../../vendor/autoload.php';

use App\Domain\Task\TaskStatus;
use App\Domain\Workspace\WorkspaceId;

$workspaceId = WorkspaceId::generate();
$taskStatus = TaskStatus::COMPLETED;
echo "Generated Workspace ID: " . $workspaceId->value() . PHP_EOL;
echo "Task status: " . $taskStatus->label() . PHP_EOL;
