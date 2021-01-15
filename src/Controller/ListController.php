<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(EntityManagerInterface $em, AnimeRepository $repo, Request $request)
    {
        $anime = new Anime;

        $form = $this->createFormBuilder($anime)
            ->add('image')
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
            'animes' => $repo->findBy(array(), array('title'=>'ASC'), 8),
            'animeForm' => $form->createView()
        ]);
    }

    /**
     * @Route("anime/{id}/edit", name="edit")
     * @param Anime $anime
     * @param Request $request
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function edit(Anime $anime, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createFormBuilder($anime)
            ->add('image')
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
     * @IsGranted("ROLE_USER")
     */
    public function delete(Anime $anime, EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($anime);
        $em->flush();

        return $this->redirectToRoute("index");
    }
}