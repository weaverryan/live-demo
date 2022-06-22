<?php

namespace App\Twig\Components;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('view_post')]
class ViewPostComponent
{
    public int $id;

    public function __construct(
        private PostRepository $postRepository
    ) {
    }

    public function getPost(): Post
    {
        return $this->postRepository->find($this->id);
    }
}