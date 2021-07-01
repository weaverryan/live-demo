<?php

namespace App\Twig\Components;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

/**
 * Renders a validatable form <strong>without</strong> the form component.
 *
 * After you edit each field ("blur" the title field, or just type into the
 * textarea), the preview is automatically updated. Both fields also have validation.
 *
 * At the bottom, you can save the form via a <code>save()</code> action.
 *
 * This also uses <code>data-loading="addClass()"</code> to give
 * the preview a low opacity while the component is loading.
 */
#[AsLiveComponent('edit_post_no_form')]
final class EditPostNoFormComponent extends AbstractController
{
    use ValidatableComponentTrait;

    /**
     * The Post itself cannot be changed, but the "title" and "content" properties
     * *can* be changed.
     */
    #[LiveProp(exposed: ['title', 'content'])]
    #[Assert\Valid]
    public Post $post;

    public bool $isSaved = false;

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        $this->validate();

        // mark a message to be shown on the frontend
        $this->isSaved = true;
        $entityManager->flush();

        // alternatively, you could set a flash and redirect
        //$this->addFlash('success', 'Post saved!');
        //return $this->redirectToRoute('app_homepage');
    }
}
