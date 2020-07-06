<?php
declare(strict_types=1);

namespace Tests\Domain\Tag;

use App\Domain\Tag\Tag;
use Tests\TestCase;

class TagTest extends TestCase
{
    public function tagProvider()
    {
        return [
            ['tag1'],
            ['tag2'],
            ['tag3'],
        ];
    }

    /**
     * @dataProvider tagProvider
     * @param $name
     */
    public function testGetters($name)
    {
        $tag = Tag::factory($name);
        $this->assertEquals($name, $tag->getName());
    }

    /**
     * @dataProvider tagProvider
     * @param $id
     * @param $name
     */
    public function testJsonSerialize($name)
    {
        $tag = Tag::factory($name);

        $expectedPayload = json_encode([
            'id' => null,
            'name' => $name,
        ]);

        $this->assertEquals($expectedPayload, json_encode($tag));
    }
}
