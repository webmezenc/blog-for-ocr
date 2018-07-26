<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $path;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpload;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeMedia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_type_media;

    public function getId()
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getDateUpload(): ?\DateTimeInterface
    {
        return $this->dateUpload;
    }

    public function setDateUpload(\DateTimeInterface $dateUpload): self
    {
        $this->dateUpload = $dateUpload;

        return $this;
    }

    public function getIdTypeMedia(): TypeMedia
    {
        return $this->id_type_media;
    }

    public function setIdTypeMedia(TypeMedia $id_type_media): self
    {
        $this->id_type_media = $id_type_media;

        return $this;
    }
}
