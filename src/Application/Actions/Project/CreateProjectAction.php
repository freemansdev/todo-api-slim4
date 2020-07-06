<?php
declare(strict_types=1);

namespace App\Application\Actions\Project;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class CreateProjectAction extends AbstractProjectAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();// getFormData();
        $id = $this->projectRepository->create($data);

        $result = [
            'id' => $id
        ];

        $this->logger->info("Project created");
        $respond = new ActionPayload(201, $result);
        return $this->respond($respond);
    }
}
