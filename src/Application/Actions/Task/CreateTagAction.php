<?php
declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class CreateTagAction extends AbstractTaskAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $this->taskRepository->saveTag((int)$this->args['id'], $data['tag']);

        $result = [
            'success' => true
        ];

        $this->logger->info("Tag created");
        $respond = new ActionPayload(201, $result);
        return $this->respond($respond);
    }
}
