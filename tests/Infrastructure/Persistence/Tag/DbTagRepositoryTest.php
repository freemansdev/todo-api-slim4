<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Tag;

use App\Domain\Tag\Tag;
use App\Domain\Tag\TagNotFoundException;
use App\Infrastructure\Persistence\Tag\DbTagRepository;
use Tests\TestCase;

class DbTagRepositoryTest extends TestCase
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
        $tag = ['name' => 'tag1'];
        $tagRepository = new DbTagRepository($this->pdo);
        $tagRepository->create($tag);
        $found = current($tagRepository->findAll());

        $expected = [
            'name' => 'tag1',
        ];

        $actual = [
            'name' => $found->getName(),
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testFindTagOfId()
    {
        $tagRepository = new DbTagRepository($this->pdo);
        $found = $tagRepository->findTagOfId(1);

        $expected = [
            'name' => 'tag1',
        ];

        $actual = [
            'name' => $found->getName(),
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testFindTagOfName()
    {
        $tagRepository = new DbTagRepository($this->pdo);
        $found = $tagRepository->findTagOfName('tag1');

        $expected = [
            'name' => 'tag1',
        ];

        $actual = [
            'name' => $found->getName(),
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testFindTagOfIdThrowsNotFoundException()
    {
        $this->expectException(\App\Domain\Tag\TagNotFoundException::class);
        $tagRepository = new DbTagRepository($this->pdo);
        $tagRepository->findTagOfId(0);
    }
}
