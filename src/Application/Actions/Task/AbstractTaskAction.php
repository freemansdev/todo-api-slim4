<?php
declare(strict_types=1);

namespace App\Application\Actions\Task;

use App\Application\Actions\Action;
use App\Domain\Task\TaskRepository;
use Psr\Log\LoggerInterface;

abstract class AbstractTaskAction extends Action
{
    /**
     * @var TaskRepository
     */
    protected $taskRepository;

    /**
     * @param LoggerInterface $logger
     * @param TaskRepository  $taskRepository
     */
    public function __construct(LoggerInterface $logger, TaskRepository $taskRepository)
    {
        parent::__construct($logger);
        $this->taskRepository = $taskRepository;
    }
}
