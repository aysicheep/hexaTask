<?php 
declare(strict_types= 1);
namespace App\Domain\Task\Exception;
use DomainException;
final class TaskNotFoundException extends DomainException {
    public function __construct(string $taskId){
        parent::__construct("Task '{$taskId}' not found.");
    }   
}