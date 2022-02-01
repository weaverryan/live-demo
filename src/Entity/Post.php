<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\String\u;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[UniqueEntity(fields: ['slug'], message: 'This slug is already taken! Try another.')]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Don\'t forget a title!')]
    #[Assert\Regex(pattern: '/[A-Z]/', message: 'Please include at least one capital letter ❤️')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 50)]
    private ?string $content = null;

    #[ORM\Column]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\OneToMany(targetEntity: PostSource::class, mappedBy: 'post', orphanRemoval: true, cascade: ['persist'])]
    #[Groups('live_component')]
    #[Assert\Valid]
    private Collection $postSources;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->postSources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        if (!$this->slug) {
            $this->slug = u((new AsciiSlugger())->slug($this->title))->lower();
        }

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|PostSource[]
     */
    public function getPostSources(): Collection
    {
        return $this->postSources;
    }

    public function addPostSource(PostSource $postSource): self
    {
        if (!$this->postSources->contains($postSource)) {
            $this->postSources[] = $postSource;
            $postSource->setPost($this);
        }

        return $this;
    }

    public function removePostSource(PostSource $postSource): self
    {
        if ($this->postSources->removeElement($postSource)) {
            // set the owning side to null (unless already changed)
            if ($postSource->getPost() === $this) {
                $postSource->setPost(null);
            }
        }

        return $this;
    }
}
