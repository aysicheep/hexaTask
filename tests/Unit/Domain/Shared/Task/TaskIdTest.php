<?php 
declare(strict_types=1);
namespace Tests\Unit\Domain\Shared\Task;

use App\Domain\Shared\Task\TaskId;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(\App\Domain\Shared\Task\TaskId::class)]
final class TaskIdTest extends TestCase
{
    public function testGenerate(): void
    {
        //Make it static and immutable:
        $taskId = TaskId::generate();
        $this->assertInstanceOf(TaskId::class, $taskId);
        $this->assertMatchesRegularExpression('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $taskId->value());
    }
}
?>