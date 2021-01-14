<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Repository\AnimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimeDescriptionController extends AbstractController
{
    /**
     * @Route("/anime/{id}", name="description", methods={"GET", "POST"})
     * @param Anime $anime
     * @param Request $request
     * @return Response
     */
    public function description(AnimeRepository $repo, int $id): Response
    {
        return $this->render('anime_description/index.html.twig', [
            'anime' => $repo->findOneBy(array('id' => $id))
        ]);
    }
}
