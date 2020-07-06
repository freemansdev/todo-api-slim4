<?php
declare(strict_types=1);

use App\Application\Actions\Project\CreateProjectAction;
use App\Application\Actions\Project\DeleteProjectAction;
use App\Application\Actions\Project\UpdateProjectAction;
use App\Application\Actions\Project\ViewProjectAction;
use App\Application\Actions\Project\ListProjectAction;
use App\Application\Actions\Task\CreateTaskAction;
use App\Application\Actions\Task\DeleteTaskAction;
use App\Application\Actions\Task\UpdateTaskAction;
use App\Application\Actions\Task\ViewTaskAction;
use App\Application\Actions\Task\ListTaskAction;
use App\Application\Actions\Task\CreateTagAction;
use App\Application\Actions\Task\DeleteTagAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\App;

return function (App $app) {
    $app->group('/projects', function (Group $group) {
        $group->post('', CreateProjectAction::class);
        $group->delete('/{id}', DeleteProjectAction::class);
        $group->put('/{id}', UpdateProjectAction::class);
        $group->get('/{id}', ViewProjectAction::class);
        $group->get('', ListProjectAction::class);
    });

    $app->group('/tasks', function (Group $group) {
        $group->post('', CreateTaskAction::class);
        $group->delete('/{id}', DeleteTaskAction::class);
        $group->put('/{id}', UpdateTaskAction::class);
        $group->get('/{id}', ViewTaskAction::class);
        $group->get('', ListTaskAction::class);
        $group->post('/{id}/tags', CreateTagAction::class);
        $group->delete('/{id}/tags/{tagName}', DeleteTagAction::class);
    });
};
