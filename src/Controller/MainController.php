<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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

        return $this->render('main/index.html.twig', [
            'post' => $post,
        ]);
    }
}
