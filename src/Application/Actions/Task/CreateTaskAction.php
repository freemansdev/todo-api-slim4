<?php
declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class CreateTaskAction extends AbstractTaskAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $id = $this->taskRepository->create($data);

        $result = [
            'id' => $id
        ];

        $this->logger->info("Task created");
        $respond = new ActionPayload(201, $result);
        return $this->respond($respond);
    }
}
