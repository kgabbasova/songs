<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SongLikeRepository")
 */
class SongLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Song", inversedBy="songLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $song;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="songLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userLiked;

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

    public function getUserLiked(): ?User
    {
        return $this->userLiked;
    }

    public function setUserLiked(?User $userLiked): self
    {
        $this->userLiked = $userLiked;

        return $this;
    }
}
