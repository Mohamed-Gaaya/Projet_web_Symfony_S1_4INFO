<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class AccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager )
    {   
        $this->entityManager = $entityManager;
    }

    #[Route('/account/modify-password', name: 'account_password')]
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {   $notification = null;
        $updated=null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $old_password = $form->get('old_password')->getData();
            
            if($encoder->isPasswordValid($user,$old_password)){
                $new_password = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user,$new_password);

                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = "your password has been changed successfully";
                $updated=true;
                
            } else{
                    $notification = "Try again — that's not your current password";
                    $updated=false;
                }
        }

        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
            'notification' => $notification,
            'message'=>$updated
        ]);
    }
}
