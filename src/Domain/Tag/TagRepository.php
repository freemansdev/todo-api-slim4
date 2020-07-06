<?php
declare(strict_types=1);

namespace App\Domain\Tag;

interface TagRepository
{
    /**
     * @return Tag[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Tag
     * @throws TagNotFoundException
     */
    public function findTagOfId(int $id): Tag;
}
