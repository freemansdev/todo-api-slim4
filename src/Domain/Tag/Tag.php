<?php
declare(strict_types=1);

namespace App\Domain\Tag;

use JsonSerializable;

class Tag implements JsonSerializable
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
     * @param string $name 
     * @return Tag
     */
    public static function factory(string $name) :Tag
    {
        $tag = new self;
        $tag->name = $name;
        return $tag;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id !== null ? (int)$this->id : null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
