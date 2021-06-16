<?php

namespace App\Twig\Components;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\LiveComponentInterface;

class PostForm extends AbstractController implements LiveComponentInterface
{
    use ComponentWithFormTrait;

    /**
     * The initial data used to create the form.
     *
     * Needed so that the same form can be re-created
     * when the component is re-rendered via Ajax.
     *
     * @LiveProp(fieldName="initialFormData")
     */
    public ?Post $post = null;

    /**
     * @LiveProp()
     */
    public string $buttonLabel = 'Save';

    private PostRepository $postRepository;

    /**
     * Components are services: so dependency injection works wonderfully!
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Used to re-create the PostType form for re-rendering.
     */
    protected function instantiateForm(): FormInterface
    {
        // we can extend AbstractController to get the normal shortcuts
        return $this->createForm(PostType::class, $this->post);
    }

    /**
     * Used in the template to suggest a way to trigger a validation error.
     */
    public function getAlreadyUsedSlugMessage(): string
    {
        $post = $this->postRepository->findOneOtherThan($this->post);

        if (!$post) {
            return '';
        }

        return sprintf('Try typing "%s" to trigger the UniqueEntity validator', $post->getSlug());
    }

    /**
     * @LiveAction()
     */
    public function save(EntityManagerInterface $entityManager)
    {
        $this->submitForm();

        if (!$this->getFormInstance()->isValid()) {
            // if the form is invalid, allow it to re-render with the errors
            return;
        }

        /** @var Post $post */
        $post = $this->getFormInstance()->getData();
        $entityManager->persist($post);
        $entityManager->flush();

        $this->addFlash('success', 'Post saved!');

        return $this->redirectToRoute('app_post_show', [
            'id' => $this->post->getId(),
        ]);
    }

    public static function getComponentName(): string
    {
        return 'post_form';
    }
}
