<?php

namespace App\Twig\Components;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\LiveComponentInterface;

class FormMarkdownTextarea extends AbstractController implements LiveComponentInterface
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

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(PostType::class, $this->post);
    }

    public static function getComponentName(): string
    {
        return 'form_markdown_textarea';
    }
}
