<?php

namespace App;

use App\Twig\Components\AddNotificationComponent;
use App\Twig\Components\AlertComponent;
use App\Twig\Components\ChangeableEditPostNoFormComponent;
use App\Twig\Components\CollectionTypeFormComponent;
use App\Twig\Components\ComplexInputComponent;
use App\Twig\Components\DateComponent;
use App\Twig\Components\EditPostNoFormComponent;
use App\Twig\Components\InputComponent;
use App\Twig\Components\MarkdownInputComponent;
use App\Twig\Components\NotificationComponent;
use App\Twig\Components\RegistrationFormComponent;
use App\Twig\Components\SearchPostComponent;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

class ExampleHelper
{
    public function getExamples(): array
    {
        $examples = [
            RegistrationFormComponent::class,
            AlertComponent::class,
            InputComponent::class,
            CollectionTypeFormComponent::class,
            ComplexInputComponent::class,
            EditPostNoFormComponent::class,
            ChangeableEditPostNoFormComponent::class,
            NotificationComponent::class,
            AddNotificationComponent::class,
            DateComponent::class,
            MarkdownInputComponent::class,
            SearchPostComponent::class,
        ];

        return $this->prepareExamples($examples);
    }

    private function prepareExamples(array $examples)
    {
        $docBlockFactory = DocBlockFactory::createInstance();

        $finalExamples = [];
        foreach ($examples as $example) {
            $reflectionClass = new \ReflectionClass($example);
            $docBlock = $reflectionClass->getDocComment() ? $docBlockFactory->create($reflectionClass->getDocComment()) : null;
            $classDescription = $docBlock ? $docBlock->getDescription() : '';
            $classDescription = str_replace("\n\n", '<br><br>', $classDescription);
            $name = $this->getComponentName($example);

            $finalExamples[$name] = [
                'class' => $example,
                'componentName' => $name,
                'shortClass' => $reflectionClass->getShortName(),
                'classSummary' => $docBlock ? $docBlock->getSummary() : '',
                'classDescription' => $classDescription,
                'isLive' => !empty($reflectionClass->getAttributes(AsLiveComponent::class)),
            ];
        }

        return $finalExamples;
    }

    private function getComponentName(string $componentClass): string
    {
        $class = new \ReflectionClass($componentClass);
        $attributes = $class->getAttributes(AsTwigComponent::class, \ReflectionAttribute::IS_INSTANCEOF);

        return $attributes[0]->getArguments()[0];
    }
}
