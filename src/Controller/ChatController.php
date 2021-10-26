<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class ChatController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function chat(): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")==null)
            return $this->redirectToRoute('login');
        return $this->render('chat/test.html.twig', ['user' => $session->get("connected_user")]);
    }
}