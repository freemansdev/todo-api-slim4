<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskRepository;
use App\Infrastructure\Persistence\Project\DbProjectRepository;
use App\Infrastructure\Persistence\Tag\DbTagRepository;

class DbTaskRepository implements TaskRepository
{
    private $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getTableName()
    {
        return 'task';
    }

    /**
     * @param int $taskId 
     * @param int $tagId 
     * @return void
     */
    public function deleteTag(int $taskId, string $tagName)
    {
        $foundTag = (new DbTagRepository($this->connection))->findTagOfName($tagName);
        $sql = "DELETE FROM task_tag WHERE task = ? and tag = ?";

        $params = [
            $taskId,
            $foundTag->getId()
        ];

        $this->connection->prepare($sql)->execute($params);
    }

    /**
     * @param int $taskId 
     * @param array $tags 
     * @return void
     */
    public function saveTag(int $taskId, array $tags)
    {
        foreach ($tags as $tag) {
            $foundTagId = (new DbTagRepository($this->connection))->create(['name' => $tag]);

            $sql = "REPLACE INTO task_tag SET
                    task=?, tag=?";
            $params = [
                $taskId,
                $foundTagId,
            ];

            $this->connection->prepare($sql)->execute($params);
        }
    }

    /**
     * @param array $task The task
     *
     * @return int The new ID
     */
    public function create(array $task): int
    {
        $project = null;
        $tag = null;

        if (isset($task['project'])) {
            $repository = new DbProjectRepository($this->connection);
            $project = $repository->findProjectOfId((int)$task['project']);
        }

        $newTask = Task::factory(
            $task['name'],
            $task['description'] ?? null,
            $project !== null ? (int)$project['id'] : null,
        );
        
        $taskId = $this->isTaskExists($newTask);

        if (!$taskId) {
            $sql = "INSERT INTO {$this->getTableName()} SET 
                    name=?, description=?, project=?";
            $params = [
                $newTask->getName(),
                $newTask->getDescription(),
                $newTask->getProject(),
            ];

            $this->connection->prepare($sql)->execute($params);
            $taskId = (int)$this->connection->lastInsertId();
        }


        if (isset($task['tag']) && $taskId) {
            $this->saveTag((int)$taskId, $task['tag']);
        }

        return $taskId;
    }

    private function isTaskExists(Task $task)
    {
        $desc = $task->getDescription() === null ? 'is ?' : ' = ?';
        $sql = <<<SQL
            SELECT t.id
            FROM {$this->getTableName()} t
            WHERE t.name = ? and t.description ${desc} and t.project = ?
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            $task->getName(),
            $task->getDescription(),
            $task->getProject(),
        ]);
        
        $found = $stmt->fetch();
        return $found ? (int)$found['id'] : $found;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $sql = <<<SQL
            SELECT t.id, t.name, t.description, t.createdAt, GROUP_CONCAT(tag.name) `tag`
            FROM {$this->getTableName()} t
            LEFT JOIN task_tag tt ON tt.task = t.id
            LEFT JOIN tag ON tag.id = tt.tag
            GROUP BY t.id
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $result = [];
        while($task = $stmt->fetch()) {
            if (isset($task['tag']))
                $task['tag'] = explode(',', $task['tag']);
            else
                unset($task['tag']);

            $result[] = $task;
        }

        return $result;
    }

    /**
     * @param int $id 
     * @return array
     */
    public function findTaskOfId(int $id): array
    {
        $sql = <<<SQL
            SELECT t.id, t.name, t.description, t.createdAt, GROUP_CONCAT(tag.name) `tag`
            FROM {$this->getTableName()} t
            JOIN task_tag tt ON tt.task = t.id
            JOIN tag ON tag.id = tt.tag
            WHERE t.id = ?
            GROUP BY t.id
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $task = $stmt->fetch();

        if (isset($task['tag']))
            $task['tag'] = explode(',', $task['tag']);
        else
            unset($task['tag']);


        if ($task) {
            return $task;
        }

        throw new TaskNotFoundException();
    }

    /**
     * @param int $id 
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM task_tag WHERE task = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);

        $sql = "DELETE FROM {$this->getTableName()} WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update(int $id, array $task): bool
    {
        $foundTask = $this->findTaskOfId($id)->jsonSerialize();
        $foundTask = array_merge($foundTask, $task);

        $sql = "UPDATE {$this->getTableName()} SET 
                name=? description=? project=? 
                WHERE id=?";
        $params = [
            $foundTask['name'],
            $foundTask['description'],
            $foundTask['project'],
            $id
        ];

        $result = $this->connection->prepare($sql)->execute($params);

        return $result;
    }

}
