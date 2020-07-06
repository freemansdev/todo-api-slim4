<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Project;

use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use App\Application\Handlers\HttpErrorHandler;
use App\Domain\Project\Project;
use App\Domain\Project\ProjectNotFoundException;
use App\Domain\Project\ProjectRepository;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

class ViewProjectActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $project = Project::factory('project0');

        $projectRepositoryProphecy = $this->prophesize(ProjectRepository::class);
        $projectRepositoryProphecy
            ->findProjectOfId(1)
            ->willReturn($project->jsonSerialize())
            ->shouldBeCalledOnce();

        $container->set(ProjectRepository::class, $projectRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/projects/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $project);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsProjectNotFoundException()
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false ,false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $projectRepositoryProphecy = $this->prophesize(ProjectRepository::class);
        $projectRepositoryProphecy
            ->findProjectOfId(0)
            ->willThrow(new ProjectNotFoundException())
            ->shouldBeCalledOnce();

        $container->set(ProjectRepository::class, $projectRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/projects/0');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The project you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
