<?php

namespace App\Twig\Components;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\PostHydrate;
use Symfony\UX\LiveComponent\LiveComponentInterface;

/**
 * A simple "Post" form where you can change which Post is being edited.
 *
 * This includes a security check to prevent the user from trying to
 * edit a post they don't own.
 *
 * Note: this does note use a Symfony form.
 */
final class ChangeableEditPostNoFormComponent implements LiveComponentInterface
{
    /**
     * The post itself is CHANGEABLE
     *
     * @LiveProp(writable=true, exposed={"title"})
     */
    public Post $post;

    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Security check for a valid Post.
     *
     * In this component, the post itself can be changed to edit a
     * different post. But perhaps that a user can only edit Post
     * objects that *they* own. We could add validation, but that's
     * not enough: we need to prevent the component from even
     * rendering if a Post is used that the user doesn't own.
     *
     * We fake that here: if the post's id is divisible by 5,
     * then we deny access.
     *
     * @PostHydrate()
     */
    public function postHydrate(): void
    {
        if ($this->post->getId() % 5 === 0) {
            throw new AccessDeniedException('You do not own this post!');
        }
    }

    /**
     * @LiveAction()
     */
    public function save(EntityManagerInterface $entityManager)
    {
        $entityManager->flush();
    }

    /**
     * @return Post[]
     */
    public function getAllPosts(): array
    {
        return $this->postRepository->findAll();
    }

    public static function getComponentName(): string
    {
        return 'changeable_edit_post_no_form';
    }
}
