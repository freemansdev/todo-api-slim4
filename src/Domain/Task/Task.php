<?php
declare(strict_types=1);

namespace App\Domain\Task;

use JsonSerializable;

class Task implements JsonSerializable
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
    private $description;

    /**
     * @var int|null
     */
    private $project;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @param string $name 
     * @param ?string|null $description 
     * @param ?int|null $project 
     * @return Task
     */
    public static function factory(string $name, ?string $description = null, ?int $project = null) :Task
    {
        $task = new self;
        $task->name = $name;
        $task->description = $description;
        $task->project = $project;
        return $task;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int|null
     */
    public function getProject(): ?int
    {
        return $this->project;
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
            'description' => $this->description,
            'project' => $this->project,
            'createdAt' => $this->createdAt,
        ];
    }
}
