<?php 
declare(strict_types=1);
namespace Tests\Unit\Domain\Task;

use App\Domain\Task\Exception\InvalidTaskTitle;
use App\Domain\Task\TaskTitle;
use PHPUnit\Framework\TestCase;

final class TaskTitleTest extends TestCase{
    
    public function testCreate() :void {
        $taskTilte = TaskTitle::create('TEST');
        $this->assertInstanceOf(TaskTitle::class,$taskTilte);
    }

    public function testCreateThrowsExceptionWhenTitleEmpty():void {
        $this->expectException(InvalidTaskTitle::class); 
        $taskTilte = TaskTitle::create('');
    }

    public function testCreateThrowsExceptionWhenTitleTooLong():void {
        $this->expectException(InvalidTaskTitle::class); 
        TaskTitle::create(str_repeat('a', 251));
    }

    public function testToString() :void {
        $taskTilte = TaskTitle::create('TEST');
        $this->assertSame($taskTilte->value(),(string) $taskTilte);
    }

}