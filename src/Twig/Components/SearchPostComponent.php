<?php

namespace App\Twig\Components;

use App\Repository\PostRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

/**
 * A search component based on Ux Live documentation.
 *
 * The component also has (A) real-time validation. If the search is not empty. A search is performed
 * and rendered with a specific nested component
 */
#[AsLiveComponent('search_post')]
class SearchPostComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getPosts(): array
    {
        return $this->postRepository->search($this->query);
    }
}