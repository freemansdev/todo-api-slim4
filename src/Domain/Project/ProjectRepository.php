<?php
declare(strict_types=1);

namespace App\Domain\Project;

interface ProjectRepository
{
    /**
     * @return Project[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Project
     * @throws ProjectNotFoundException
     */
    public function findProjectOfId(int $id): array;
}
