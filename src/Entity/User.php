<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Song", mappedBy="owner", orphanRemoval=true)
     */
    private $songs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SongLike", mappedBy="userLiked", orphanRemoval=true)
     */
    private $songLikes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SongDislikes", mappedBy="userDisliked", orphanRemoval=true)
     */
    private $songDislikes;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
        $this->songLikes = new ArrayCollection();
        $this->songDislikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Song[]
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs[] = $song;
            $song->setOwner($this);
        }

        return $this;
    }

    public function removeSong(Song $song): self
    {
        if ($this->songs->contains($song)) {
            $this->songs->removeElement($song);
            // set the owning side to null (unless already changed)
            if ($song->getOwner() === $this) {
                $song->setOwner(null);
            }
        }

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
            $songLike->setUserLiked($this);
        }

        return $this;
    }

    public function removeSongLike(SongLike $songLike): self
    {
        if ($this->songLikes->contains($songLike)) {
            $this->songLikes->removeElement($songLike);
            // set the owning side to null (unless already changed)
            if ($songLike->getUserLiked() === $this) {
                $songLike->setUserLiked(null);
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
            $songDislike->setUserDisliked($this);
        }

        return $this;
    }

    public function removeSongDislike(SongDislikes $songDislike): self
    {
        if ($this->songDislikes->contains($songDislike)) {
            $this->songDislikes->removeElement($songDislike);
            // set the owning side to null (unless already changed)
            if ($songDislike->getUserDisliked() === $this) {
                $songDislike->setUserDisliked(null);
            }
        }

        return $this;
    }
}
