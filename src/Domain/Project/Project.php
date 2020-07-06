<?php
declare(strict_types=1);

namespace App\Domain\Project;

use JsonSerializable;

class Project implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @param string $name 
     * @return Project
     */
    public static function factory(string $name) :Project
    {
        $project = new self;
        $project->name = $name;
        return $project;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id ? (int)$this->id : null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'createdAt' => $this->createdAt,
        ];
    }
}
