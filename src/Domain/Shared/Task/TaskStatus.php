<?php  
    declare(strict_types=1);
    namespace App\Domain\Shared\Task;
    
    Enum TaskStatus :string {
        case TODO = "todo";
        case IN_PROGRESS = "in_progress";
        case COMPLETED = "completed";


        public function canTransitionTo (self $task):bool {
            return match($this) {
                self::TODO => in_array($task, [self::IN_PROGRESS, self::COMPLETED]),
                self::IN_PROGRESS => in_array($task, [self::COMPLETED]),
                self::COMPLETED => false,
            };
        }


        public function label():string{
            return match($this){
                self::TODO => 'A faire',
                self::IN_PROGRESS => 'En cours',
                self::COMPLETED => 'Terminé', 
            };
        }
    }
?>