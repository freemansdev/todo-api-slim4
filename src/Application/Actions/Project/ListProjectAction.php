<?php
declare(strict_types=1);

namespace App\Application\Actions\Project;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class ListProjectAction extends AbstractProjectAction
{
    protected function action(): Response
    {
        $projects = $this->projectRepository->findAll();
        return $this->respondWithData($projects);
    }
}
