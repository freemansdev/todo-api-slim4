<?php
declare(strict_types=1);

namespace App\Domain\Task;

interface TaskRepository
{
    /**
     * @return Task[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Task
     * @throws TaskNotFoundException
     */
    public function findTaskOfId(int $id): array;
}
