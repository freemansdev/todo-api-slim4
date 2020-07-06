<?php
declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class DeleteTagAction extends AbstractTaskAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        extract($this->args);

        $this->taskRepository->deleteTag((int)$id, $tagName);

        $result = [
            'success' => true
        ];

        $this->logger->info("Tag deleted");
        $respond = new ActionPayload(200, $result);
        return $this->respond($respond);
    }
}
