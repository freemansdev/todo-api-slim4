<?php
declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class UpdateTaskAction extends AbstractTaskAction
{
    protected function action(): Response
    {
        if (current($this->request->getHeader('Content-Type')) === 'application/json')
            $contents = json_decode($this->request->getBody()->getContents());
        else
            parse_str($this->request->getBody()->getContents(), $contents);

        $taskId = (int) $this->resolveArg('id');

        $result = [
            'success' => $this->taskRepository->update($taskId, $contents)
        ];

        $this->logger->info("Task updated");
        $respond = new ActionPayload(200, $result);
        return $this->respond($respond);
    }
}
