<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Infrastructure\Persistence\Task\DbTaskRepository;
use Tests\TestCase;

class DbTaskRepositoryTest extends TestCase
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
        $task = Task::factory('task1', 'description', 1);
        $taskArray = $task->jsonSerialize();
        $taskArray['tag'] = ['tag1', 'tag2'];

        $taskRepository = new DbTaskRepository($this->pdo);
        $taskRepository->create($taskArray);
        $found = current($taskRepository->findAll());

        $expected = [
            'name' => 'task1',
            'description' => 'description',
            'tag' => ['tag1', 'tag2'],
        ];

        $actual = [
            'name' => $found['name'],
            'description' => $found['description'],
            'tag' => $found['tag'],
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testFindTaskOfId()
    {
        $taskRepository = new DbTaskRepository($this->pdo);
        $found = $taskRepository->findTaskOfId(1);

        $expected = [
            'name' => 'task1',
            'description' => 'description',
            'tag' => ['tag1', 'tag2'],
        ];

        $actual = [
            'name' => $found['name'],
            'description' => $found['description'],
            'tag' => $found['tag'],
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testFindTaskOfIdThrowsNotFoundException()
    {
        $this->expectException(\App\Domain\Task\TaskNotFoundException::class);
        $taskRepository = new DbTaskRepository($this->pdo);
        $taskRepository->findTaskOfId(0);
    }
}
