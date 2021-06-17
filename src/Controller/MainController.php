<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Twig\Components\AlertComponent;
use App\Twig\Components\ChangeableEditPostNoFormComponent;
use App\Twig\Components\ComplexInputComponent;
use App\Twig\Components\EditPostNoFormComponent;
use App\Twig\Components\InputComponent;
use App\Twig\Components\AddNotificationComponent;
use App\Twig\Components\NotificationComponent;
use App\Twig\Components\RegistrationFormComponent;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\LiveComponent\LiveComponentInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(PostRepository $repo)
    {
        // find any Post
        $post = $repo->findOneBy([]);
        if (!$post) {
            throw new \Exception('Run php bin/console doctrine:fixtures:load to load the fixtures!');
        }

        $examples = [
            AlertComponent::class,
            InputComponent::class,
            RegistrationFormComponent::class,
            ComplexInputComponent::class,
            EditPostNoFormComponent::class,
            ChangeableEditPostNoFormComponent::class,
            NotificationComponent::class,
            AddNotificationComponent::class,
        ];

        $examples = $this->prepareExamples($examples);

        return $this->render('main/index.html.twig', [
            'post' => $post,
            'examples' => $examples,
        ]);
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

            $finalExamples[] = [
                'class' => $example,
                'componentName' => $example::getComponentName(),
                'shortClass' => $reflectionClass->getShortName(),
                'classSummary' => $docBlock ? $docBlock->getSummary() : '',
                'classDescription' => $classDescription,
                'isLive' => in_array(LiveComponentInterface::class, class_implements($example), true),
            ];
        }

        return $finalExamples;
    }
}
