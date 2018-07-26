<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaAssociatedRepository")
 */
class MediaAssociated
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Media")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_media;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Post;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_adding;

    public function getId()
    {
        return $this->id;
    }

    public function getIdMedia(): ?Media
    {
        return $this->id_media;
    }

    public function setIdMedia(?Media $id_media): self
    {
        $this->id_media = $id_media;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->Post;
    }

    public function setPost(?Post $Post): self
    {
        $this->Post = $Post;

        return $this;
    }

    public function getDateAdding(): ?\DateTimeInterface
    {
        return $this->date_adding;
    }

    public function setDateAdding(\DateTimeInterface $date_adding): self
    {
        $this->date_adding = $date_adding;

        return $this;
    }
}
