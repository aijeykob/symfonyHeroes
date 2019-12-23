<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HeroRepository")
 */
class Hero
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $real_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origin_description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $superpowers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $catch_phrase;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $heroImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getRealName(): ?string
    {
        return $this->real_name;
    }

    public function setRealName(?string $real_name): self
    {
        $this->real_name = $real_name;

        return $this;
    }

    public function getOriginDescription(): ?string
    {
        return $this->origin_description;
    }

    public function setOriginDescription(?string $origin_description): self
    {
        $this->origin_description = $origin_description;

        return $this;
    }

    public function getSuperpowers(): ?string
    {
        return $this->superpowers;
    }

    public function setSuperpowers(?string $superpowers): self
    {
        $this->superpowers = $superpowers;

        return $this;
    }

    public function getCatchPhrase(): ?string
    {
        return $this->catch_phrase;
    }

    public function setCatchPhrase(?string $catch_phrase): self
    {
        $this->catch_phrase = $catch_phrase;

        return $this;
    }

    public function getHeroImage(): ?string
    {
        return $this->heroImage;
    }

    public function setHeroImage(?string $heroImage): self
    {
        $this->heroImage = $heroImage;

        return $this;
    }
}
