<?php
declare(strict_types=1);

namespace Tests\Domain\Project;

use App\Domain\Project\Project;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    public function projectProvider()
    {
        return [
            ['test1'],
            ['test2'],
            ['test3'],
            ['test4'],
        ];
    }

    /**
     * @dataProvider projectProvider
     * @param $name
     */
    public function testGetters($name)
    {
        $project = Project::factory($name);
        $this->assertEquals($name, $project->getName());
    }

    /**
     * @dataProvider projectProvider
     * @param $id
     * @param $name
     */
    public function testJsonSerialize($name)
    {
        $project = Project::factory($name);

        $expectedPayload = json_encode([
            'id' => null,
            'name' => $name,
            'createdAt' => null,
        ]);

        $this->assertEquals($expectedPayload, json_encode($project));
    }
}
