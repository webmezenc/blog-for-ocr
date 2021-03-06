<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
{
    const COMMENTS_INVALID = 0;
    const COMMENTS_VALID = 1;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_create;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_validation;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=100,minMessage="Le commentaire doit contenir au moins 100 caractères")
     * @Assert\Regex(pattern="/([a-zA-Z]*@[a-zA-Z]*\.[a-zA-Z]*)/",match=false,message="Le commentaire ne doit pas contenir d'adresse email")
     * @Assert\Regex(pattern="/http:\/\/[a-zA-Z]*\.[a-zA-Z]*\//", match=false,message="Le commentaire ne doit pas contenir d'URL")
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    public function getId()
    {
        return $this->id;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->date_validation;
    }

    public function setDateValidation(?\DateTimeInterface $date_validation): self
    {
        $this->date_validation = $date_validation;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getIdPost(): ?Post
    {
        return $this->id_post;
    }

    public function setIdPost(?Post $id_post): self
    {
        $this->id_post = $id_post;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
