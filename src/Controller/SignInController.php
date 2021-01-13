<?php

namespace App\Controller;

use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SignInController extends AbstractController
{
    /**
     * @Route("/signin", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $member = new Member;

        $form = $this->createFormBuilder($member)
            ->add('username')
            ->add('password', PasswordType::class)
            ->add('passwordVerify', PasswordType::class)
            ->add('email')
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $member->setRegistrationDate(new \DateTime());

            $hash = $encoder->encodePassword($member, $member->getPassword());
            $member->setPassword($hash);

            $em->persist($member);
            $em->flush();

            return $this->redirectToRoute('app_login_login');
        }

        return $this->render('sign_in/index.html.twig', [
            'signInForm' => $form->createView(),
        ]);
    }
}
