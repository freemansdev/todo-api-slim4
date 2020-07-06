<?php
declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class ListTaskAction extends AbstractTaskAction
{
    protected function action(): Response
    {
        $tasks = $this->taskRepository->findAll();
        return $this->respondWithData($tasks);
    }
}
