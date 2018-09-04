<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostCategoryRepository")
 */
class PostCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=250, nullable=false)
     */
    private $name;

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getName(): string
    {
        return $this -> name;
    }

    public function setName( string $name ): self
    {
        $this -> name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this -> name;
    }
}
