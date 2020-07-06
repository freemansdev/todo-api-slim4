<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Project;

use App\Domain\Project\Project;
use App\Domain\Project\ProjectNotFoundException;
use App\Domain\Project\ProjectRepository;
use App\Infrastructure\Persistence\Task\DbTaskRepository;

class DbProjectRepository implements ProjectRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getTableName()
    {
        return 'project';
    }

    /**
     * @param array $project The project
     *
     * @return int The new ID
     */
    public function create(array $project): int
    {
        $project = Project::factory($project['name']);
        $sql = "INSERT INTO {$this->getTableName()} SET 
                name=?";
        $params = [$project->getName()];

        $this->connection->prepare($sql)->execute($params);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $sql = <<<SQL
            SELECT p.id, p.name, p.createdAt, GROUP_CONCAT(t.id) task
            FROM {$this->getTableName()} p
            left JOIN task t ON t.project = p.id
            GROUP BY p.id
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $result = [];
        while($project = $stmt->fetch()) {
            if (isset($project['task']))
                $project['task'] = explode(',', $project['task']);
            else
                unset($project['task']);

            $result[] = $project;
        }

        return $result;
    }

    /**
     * @param int $id 
     * @return array
     */
    public function findProjectOfId(int $id): array
    {
        $sql = <<<SQL
            SELECT p.id, p.name, p.createdAt, GROUP_CONCAT(t.id) task
            FROM {$this->getTableName()} p
            left JOIN task t ON t.project = p.id
            WHERE p.id = ?
            GROUP BY p.id
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        $project = $stmt->fetch();

        if (isset($project['task']))
            $project['task'] = explode(',', $project['task']);
        else
            unset($project['task']);

        if ($project) {
            return $project;
        }

        throw new ProjectNotFoundException();
    }

    /**
     * @param int $id 
     * @return bool
     */
    public function delete(int $id): bool
    {
        $project = $this->findProjectOfId($id);
        $tasks = $project['task'];

        if (!empty($tasks)) {
            $tasksIn = implode(',', array_fill(0, count($tasks), '?'));
            $sql = "DELETE FROM task_tag WHERE task in (${tasksIn})";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($tasks);

            foreach ($tasks as $task)
                (new DbTaskRepository($this->connection))->delete((int)$task);
        }

        $sql = "DELETE FROM {$this->getTableName()} WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function update(int $id, array $project): bool
    {
        $sql = "UPDATE {$this->getTableName()} SET 
                name=? 
                WHERE id=?";
        $params = [
            $project['name'],
            $id
        ];

        $result = $this->connection->prepare($sql)->execute($params);

        return $result;
    }

}
