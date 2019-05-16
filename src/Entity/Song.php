<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SongRepository")
 */
class Song
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $singer;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="songs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SongLike", mappedBy="song", orphanRemoval=true)
     */
    private $songLikes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SongDislikes", mappedBy="song", orphanRemoval=true)
     */
    private $songDislikes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $likesAmount = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dislikesAmount =0;

    public function __construct()
    {
        $this->songLikes = new ArrayCollection();
        $this->songDislikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getSinger(): ?string
    {
        return $this->singer;
    }

    public function setSinger(string $singer): self
    {
        $this->singer = $singer;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(?\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|SongLike[]
     */
    public function getSongLikes(): Collection
    {
        return $this->songLikes;
    }

    public function addSongLike(SongLike $songLike): self
    {
        if (!$this->songLikes->contains($songLike)) {
            $this->songLikes[] = $songLike;
            $songLike->setSong($this);
        }

        return $this;
    }

    public function removeSongLike(SongLike $songLike): self
    {
        if ($this->songLikes->contains($songLike)) {
            $this->songLikes->removeElement($songLike);
            // set the owning side to null (unless already changed)
            if ($songLike->getSong() === $this) {
                $songLike->setSong(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SongDislikes[]
     */
    public function getSongDislikes(): Collection
    {
        return $this->songDislikes;
    }

    public function addSongDislike(SongDislikes $songDislike): self
    {
        if (!$this->songDislikes->contains($songDislike)) {
            $this->songDislikes[] = $songDislike;
            $songDislike->setSong($this);
        }

        return $this;
    }

    public function removeSongDislike(SongDislikes $songDislike): self
    {
        if ($this->songDislikes->contains($songDislike)) {
            $this->songDislikes->removeElement($songDislike);
            // set the owning side to null (unless already changed)
            if ($songDislike->getSong() === $this) {
                $songDislike->setSong(null);
            }
        }

        return $this;
    }

    public function getLikesAmount(): ?int
    {
        return $this->likesAmount;
    }

    public function setLikesAmount(?int $likesAmount): self
    {
        $this->likesAmount = $likesAmount;

        return $this;
    }

    public function getDislikesAmount(): ?int
    {
        return $this->dislikesAmount;
    }

    public function setDislikesAmount(?int $dislikesAmount): self
    {
        $this->dislikesAmount = $dislikesAmount;

        return $this;
    }


    private $file;


    public function getFile()
    {
        return $this->file;
    }


    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return boolean
     */
    public function getIsUserLiked()
    {
        return $this->isUserLiked;
    }

    /**
     * @param boolean $isUserLiked
     */
    public function setIsUserLiked($isUserLiked): void
    {
        $this->isUserLiked = $isUserLiked;
    }

    /**
     * @return boolean
     */
    public function getIsUserDisliked()
    {
        return $this->isUserDisliked;
    }

    /**
     * @param boolean $isUserDisliked
     */
    public function setIsUserDisliked($isUserDisliked): void
    {
        $this->isUserDisliked = $isUserDisliked;
    }

    private $isUserLiked;

    private $isUserDisliked;
}
