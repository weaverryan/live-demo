<?php

namespace App\Twig\Components;

use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;

/**
 * Renders the registration form with automatic validation as you change fields.
 *
 * This is a LIVE component: try entering an invalid email address
 * or a short password, then focus away from the field.
 */
#[AsLiveComponent('registration_form')]
class RegistrationFormComponent extends AbstractController
{
    use ComponentWithFormTrait;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(RegistrationFormType::class);
    }
}
