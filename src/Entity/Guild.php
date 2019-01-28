<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GuildRepository")
 */
class Guild
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $guild_discord_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $guild_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="guild")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuildDiscordId(): ?int
    {
        return $this->guild_discord_id;
    }

    public function setGuildDiscordId(?int $guild_discord_id): self
    {
        $this->guild_discord_id = $guild_discord_id;

        return $this;
    }

    public function getGuildName(): ?string
    {
        return $this->guild_name;
    }

    public function setGuildName(string $guild_name): self
    {
        $this->guild_name = $guild_name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setGuild($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getGuild() === $this) {
                $user->setGuild(null);
            }
        }

        return $this;
    }
}
