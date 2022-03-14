<?php

namespace App\Entity;

use App\Repository\PostSourceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

#[ORM\Entity(repositoryClass: PostSourceRepository::class)]
class PostSource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[NotBlank]
    #[ORM\Column]
    private ?string $description;

    #[NotBlank]
    #[Url]
    #[ORM\Column]
    private ?string $url;

    #[ORM\ManyToOne(inversedBy: 'postSources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}
