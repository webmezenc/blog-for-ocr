<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogOptionsRepository")
 */
class BlogOptions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TypeBlogOptions", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_type_blog;

    public function getId()
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getIdTypeBlog(): ?TypeBlogOptions
    {
        return $this->id_type_blog;
    }

    public function setIdTypeBlog(TypeBlogOptions $id_type_blog): self
    {
        $this->id_type_blog = $id_type_blog;

        return $this;
    }
}
