<?php 
declare(strict_types=1);
namespace Tests\Unit\Domain\Shared\Task;
use App\Domain\Task\TaskStatus;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
#[CoversClass(TaskStatus::class)]
final class TaskStatusTest extends TestCase {

#[DataProvider('transitions')]        
public function testCanTransitTo(TaskStatus $from,TaskStatus $to,bool $expected): void {
            $this->assertSame($expected, $from->canTransitionTo($to));
        }


        public static function transitions() : array{
            return [
            'todo -> in progress' => [TaskStatus::TODO, TaskStatus::IN_PROGRESS,true],
            'completed -> in progress'=> [TaskStatus::COMPLETED, TaskStatus::IN_PROGRESS,false],
            'completed -> todo'=> [TaskStatus::COMPLETED, TaskStatus::TODO,false],
            'in progress -> completed' => [TaskStatus::IN_PROGRESS, TaskStatus::COMPLETED,true],
            ];
        }
     }