<?php
declare(strict_types=1);

namespace App\Application\Actions\Project;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\ActionPayload;

class ViewProjectAction extends AbstractProjectAction
{
    protected function action(): Response
    {
        $projectId = (int) $this->resolveArg('id');
        $project = $this->projectRepository->findProjectOfId($projectId);
        return $this->respondWithData($project);
    }
}
