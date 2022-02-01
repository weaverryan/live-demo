<?php

namespace App\Twig\Components;

use App\Entity\Post;
use App\Form\PostWithSourcesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

/**
 * Renders an embedded array of forms via CollectionType
 *
 * This is a LIVE component: click the "+" or "-" buttons
 * to trigger a server-side update, which adds/removes the
 * embedded form.
 */
#[AsLiveComponent('collection_type_form')]
class CollectionTypeFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'data')]
    public ?Post $post = null;

    protected function instantiateForm(): FormInterface
    {
        // TODO: fix losing full validation
        return $this->createForm(PostWithSourcesType::class, $this->post);
    }

    #[LiveAction]
    public function addSource()
    {
        // add a new "post source" into the form data
        $this->formValues['postSources'][] = [];
    }

    #[LiveAction]
    public function removeSource(#[LiveArg] int $index)
    {
        // remove the "post source" from the form data
        unset($this->formValues['postSources'][$index]);
    }
}
