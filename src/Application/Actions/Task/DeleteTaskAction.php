<?php
declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class DeleteTaskAction extends AbstractTaskAction
{
    protected function action(): Response
    {
        $taskId = (int) $this->resolveArg('id');
        $task = $this->taskRepository->delete($taskId);
        return $this->respondWithData(['success' => $task]);
    }
}
