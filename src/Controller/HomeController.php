<?php
// src/Controller/HomeController.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class HomeController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function index(): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")==null)
            return $this->redirectToRoute('login');
        return $this->render('home/index.html.twig', ['user' => $session->get("connected_user")]);
    }

    public function login(): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")!=null)
            return $this->redirectToRoute('index');
        return $this->render('home/login.html.twig');
    }

    public function connect(Request $request): Response
    {
        $data=$request->getContent();
        $data = json_decode($data, true);
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($data['login']);
        if($user == null)
            return $this->json('user_not_found');
        if(!password_verify($data['password'], $user->getPassword()))
            return $this->json('wrong_password');
        $session = $this->requestStack->getSession();
        $session->set("connected_user", $user);
        return $this->json($session->get("connected_user")->getLogin());
        // return $this->json($data['login']);
    }
}