<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Project;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectNotFoundException;
use App\Infrastructure\Persistence\Project\DbProjectRepository;
use Tests\TestCase;

class DbProjectRepositoryTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        parent::setUp();
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $this->pdo = $container->get(\PDO::class);
    }

    public function testFindAll()
    {
        $project = Project::factory('project1');

        $projectRepository = new DbProjectRepository($this->pdo);
        $projectRepository->create($project->jsonSerialize());

        $expected = [
            'name' => 'project1'
        ];

        $actual = $projectRepository->findAll();

        $this->assertEquals($expected, ['name' => current($actual)['name']]);
    }

    public function testFindProjectOfId()
    {
        $projectRepository = new DbProjectRepository($this->pdo);
        $found = $projectRepository->findProjectOfId(1);

        $expected = [
            'id' => '1'
        ];

        $this->assertEquals($expected['id'], $found['id']);
    }

    public function testFindProjectOfIdThrowsNotFoundException()
    {
        $this->expectException(\App\Domain\Project\ProjectNotFoundException::class);
        $projectRepository = new DbProjectRepository($this->pdo);
        $projectRepository->findProjectOfId(0);
    }
}
