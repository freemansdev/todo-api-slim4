<?php
declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class ViewTaskAction extends AbstractTaskAction
{
    protected function action(): Response
    {
        $taskId = (int) $this->resolveArg('id');
        $task = $this->taskRepository->findTaskOfId($taskId);
        return $this->respondWithData($task);
    }
}
