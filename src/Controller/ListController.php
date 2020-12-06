<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EntityManagerInterface $em, AnimeRepository $repo, Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            $anime = new Anime;
            $anime->setTitle($data['title']);
            $anime->setDescription($data['description']);

            $em->persist($anime);
            $em->flush();
        }

        return $this->render('list/index.html.twig', [
            'animes' => $repo->findBy(array(), array('id'=>'DESC'), 15)
        ]);
    }
}
