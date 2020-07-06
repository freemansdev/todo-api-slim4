<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Tag;

use App\Domain\Tag\Tag;
use App\Domain\Tag\TagNotFoundException;
use App\Domain\Tag\TagRepository;

class DbTagRepository implements TagRepository
{
    private $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getTableName()
    {
        return 'tag';
    }

    /**
     * @param array $tag The tag
     *
     * @return int The new ID
     */
    public function create(array $tag): int
    {
        try {
            $foundTag = $this->findTagOfName($tag['name']);
            return $foundTag->getId();
        } catch (TagNotFoundException $e) {
            $tag = Tag::factory($tag['name']);
            $sql = "INSERT INTO {$this->getTableName()} SET 
                    name=?";
            $params = [$tag->getName()];
            $this->connection->prepare($sql)->execute($params);
            return (int)$this->connection->lastInsertId();
        }    
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $result = [];
        while($tag = $stmt->fetchObject(Tag::class))
            $result[] = $tag;

        return $result;
    }

    /**
     * @param string $name 
     * @return Tag
     */
    public function findTagOfName(string $name): Tag
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE name = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$name]);
        $tag = $stmt->fetchObject(Tag::class);

        if ($tag) {
            return $tag;
        }

        throw new TagNotFoundException();
    }

    /**
     * @param int $id 
     * @return Tag
     */
    public function findTagOfId(int $id): Tag
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $tag = $stmt->fetchObject(Tag::class);

        if ($tag) {
            return $tag;
        }

        throw new TagNotFoundException();
    }

    /**
     * @param int $id 
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->getTableName()} WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update(int $id, array $tag): bool
    {
        $sql = "UPDATE {$this->getTableName()} SET 
                name=? 
                WHERE id=?";
        $params = [
            $tag['name'],
            $id
        ];

        $result = $this->connection->prepare($sql)->execute($params);

        return $result;
    }
}
