<?php
namespace App\Controller;

use App\Entity\User;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class UserController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    //Using cache
    public function list(AdapterInterface $cache): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")==null)
            return $this->redirectToRoute('login');
        $users = $cache->getItem("users");
        if(!$users->isHit()){
            $users->set($this->getDoctrine()
                ->getRepository(User::class)
                ->findAll());
            $cache->save($users);
        }
        return $this->render('user/list.html.twig', ['users' => $users->get()]);
    }

    //Not using cache
    // public function list(): Response
    // {
    //     $session = $this->requestStack->getSession();
    //     if($session->get("connected_user")==null)
    //         return $this->redirectToRoute('login');
    //     $users = $this->getDoctrine()
    //         ->getRepository(User::class)
    //         ->findAll();
    //     return $this->render('user/list.html.twig', ['users' => $users]);
    // }

    public function add(): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")==null)
            return $this->redirectToRoute('login');
        return $this->render('user/add.html.twig');
    }

    public function save(): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")==null)
            return $this->redirectToRoute('login');
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setLogin($_POST["username"])
            ->setPassword(password_hash($_POST["password"], PASSWORD_BCRYPT))
            ->setFirstname($_POST["firstname"])
            ->setLastname($_POST["lastname"])
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime());
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('user_list');
    }

    public function edit(string $username): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")==null)
            return $this->redirectToRoute('login');
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($username);
        if($user == null)
            return $this->render('error/404.html.twig', ['error_title' => 'Introuvable', 'error_message' => "L'utilisateur demandé est introuvable"]);
        return $this->render('user/edit.html.twig', ["user"=>$user]);
    }

    public function update(string $username): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")==null)
            return $this->redirectToRoute('login');
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($username);
        $user->setLogin($_POST["username"])
            ->setFirstname($_POST["firstname"])
            ->setLastname($_POST["lastname"])
            ->setUpdatedAt(new DateTime());
        $entityManager->flush();
        return $this->redirectToRoute('user_list');
    }

    public function delete(string $username): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($username);
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('user_list');
    }

    public function checkUsername(): Response
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($_GET["login"]);
        if($user == null)
            return $this->json('unique');
        return $this->json('not_unique');
    }
}