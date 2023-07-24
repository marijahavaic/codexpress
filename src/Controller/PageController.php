<?php

namespace App\Controller;

use App\Repository\SnippetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


class PageController extends AbstractController
{
    // Route de la page d'accueil
    #[Route('/', name: 'app_page')]
    public function index(
        SnippetRepository $snippets,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $query = $snippets->findBy(
            ['isPublished' => true], //pour selectionner
            ['createdAt' => 'DESC'], // pour trier
            100 //Pour limiter l'affichage
        );

        // On utilise le paginator pour paginer les snippets
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        
        return $this->render('page/index.html.twig', [
            'snippets' => $pagination,
        ]);
    }
}
