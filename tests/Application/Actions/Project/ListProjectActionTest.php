<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Project;

use App\Application\Actions\ActionPayload;
use App\Domain\Project\ProjectRepository;
use App\Domain\Project\Project;
use DI\Container;
use Tests\TestCase;

class ListProjectActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $project = Project::factory('project1');

        $projectRepositoryProphecy = $this->prophesize(ProjectRepository::class);
        $projectRepositoryProphecy
            ->findAll()
            ->willReturn([$project])
            ->shouldBeCalledOnce();

        $container->set(ProjectRepository::class, $projectRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/projects');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$project]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
