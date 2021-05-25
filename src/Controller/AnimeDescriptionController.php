<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimeDescriptionController extends AbstractController
{
    /**
     * @Route("/anime/{id}", name="description")
     */
    public function description()
    {
        return $this->render('anime_description/index.html.twig');
    }
}
