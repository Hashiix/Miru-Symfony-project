<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("")
     */
    public function index(EntityManagerInterface $em, AnimeRepository $repo, Request $request)
    {
        $anime = new Anime;

        $form = $this->createFormBuilder($anime)
            ->add('title')
            ->add('description')
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($anime);
            $em->flush();
        }

        return $this->render('list/index.html.twig', [
            'animes' => $repo->findBy(array(), array('id'=>'DESC'), 8),
            'animeForm' => $form->createView()
        ]);
    }

    /**
     * @Route("anime/{id}/edit", name="edit")
     * @param Anime $anime
     * @param Request $request
     * @return Response
     */
    public function edit(Anime $anime, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createFormBuilder($anime)
            ->add('title')
            ->add('description')
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($anime);
            $em->flush();

            return $this->redirectToRoute("index");
        }

        return $this->render('list/edit.html.twig', [
            'animeForm' => $form->createView()
        ]);
    }

    /**
     * @Route("anime/{id}/delete", name="delete")
     * @param Anime $anime
     * @return RedirectResponse
     */
    public function delete(Anime $anime, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($anime);
        $em->flush();

        return $this->redirectToRoute("index");
    }
}