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
        return $this->render('index.html.twig', ['user' => $session->get("connected_user")]);
    }

    public function login(): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")!=null)
            return $this->redirectToRoute('index');
        return $this->render('login.html.twig');
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

    
    public function test_calcul(): Response
    {
        $start_time = microtime(true);
        $sums = array();
        $times = array();
        for ($i = 1; $i <= 1000; $i++) {
            $var1 = rand(1, 1000000) / 100.0;
            $var2 = rand(1, 1000000) / 100.0;
            $sum = $var1 + $var2;
            $time = $var1 * $var2;
            array_push($sums, $sum);
            array_push($times, $time);
        }
        $end_time = microtime(true);
        $result = array("sums" => $sums, "times" => $times, "ellapsed_time" => ($end_time-$start_time)*1000);
        return $this->json($result);
    }
}