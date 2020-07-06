<?php
declare(strict_types=1);

namespace Tests\Domain\Task;

use App\Domain\Task\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function taskProvider()
    {
        return [
            ['task1', 'description1', 1],
            ['task2', 'description2', 2],
            ['task3', 'description3', 3],
            ['task4', 'description4', 4],
        ];
    }

    /**
     * @dataProvider taskProvider
     * @param $name
     */
    public function testGetters($name, $description, $project)
    {
        $task = Task::factory($name, $description, $project);
        
        $this->assertEquals($name, $task->getName());
        $this->assertEquals($description, $task->getDescription());
        $this->assertEquals($project, $task->getProject());
    }

    /**
     * @dataProvider taskProvider
     * @param $id
     * @param $name
     */
    public function testJsonSerialize($name)
    {
        $task = Task::factory($name);

        $expectedPayload = json_encode([
            'id' => null,
            'name' => $name,
            'description' => $description,
            'project' => $this->project,
            'createdAt' => null,
        ]);

        $this->assertEquals($expectedPayload, json_encode($task));
    }
}
