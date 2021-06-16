<?php

namespace App\Twig\Components;

use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\LiveComponentInterface;

/**
 * Renders the registration form with automatic validation as you change fields.
 *
 * This is a LIVE component: try entering an invalid email address
 * or a short password, then focus away from the field.
 */
class RegistrationFormComponent extends AbstractController implements LiveComponentInterface
{
    use ComponentWithFormTrait;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(RegistrationFormType::class);
    }

    public static function getComponentName(): string
    {
        return 'registration_form';
    }
}
