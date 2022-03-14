<?php

namespace App\Controller;

use App\ExampleHelper;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(PostRepository $repo)
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/demo/{example}', name: 'app_example')]
    public function example(string $example, ExampleHelper $exampleHelper, PostRepository $repo)
    {
        // find any Post, needed for some components
        $post = $repo->findOneBy([]);
        if (!$post) {
            throw new \Exception('Run php bin/console doctrine:fixtures:load to load the fixtures!');
        }

        $examples = $exampleHelper->getExamples();
        if (!isset($examples[$example])) {
            throw $this->createNotFoundException();
        }

        return $this->render('main/example.html.twig', [
            'post' => $post,
            'example' => $examples[$example],
        ]);
    }
}
