<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocialNetworkRepository")
 */
class SocialNetwork
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $value;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TypeSocialNetwork", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_type_social_network;

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

    public function getIdTypeSocialNetwork(): ?TypeSocialNetwork
    {
        return $this->id_type_social_network;
    }

    public function setIdTypeSocialNetwork(TypeSocialNetwork $id_type_social_network): self
    {
        $this->id_type_social_network = $id_type_social_network;

        return $this;
    }
}
