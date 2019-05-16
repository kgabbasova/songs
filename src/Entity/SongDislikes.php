<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SongDislikesRepository")
 */
class SongDislikes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Song", inversedBy="songDislikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $song;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="songDislikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userDisliked;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSong(): ?Song
    {
        return $this->song;
    }

    public function setSong(?Song $song): self
    {
        $this->song = $song;

        return $this;
    }

    public function getUserDisliked(): ?User
    {
        return $this->userDisliked;
    }

    public function setUserDisliked(?User $userDisliked): self
    {
        $this->userDisliked = $userDisliked;

        return $this;
    }
}
