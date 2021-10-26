<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class CalculationController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function calculation(): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")==null)
            return $this->redirectToRoute('login');
        return $this->render('calculation/test.html.twig', ['user' => $session->get("connected_user")]);
    }
    
    public function ajax_test(): Response
    {
        $ellapsed_times = array();
        $min_time = null;
        $max_time = null;
        for ($j = 1; $j <= 100; $j++) {
            $start_time = microtime(true);
            // $sums = array();
            // $times = array();
            for ($i = 1; $i <= 1000000; $i++) {
                $var1 = rand(1, 1000000) / 100.0;
                $var2 = rand(1, 1000000) / 100.0;
                $sum = $var1 + $var2;
                $time = $var1 * $var2;
                $div = $var1 / $var2;
                // array_push($sums, $sum);
                // array_push($times, $time);
            }
            $end_time = microtime(true);
            $ellapsed_time = $end_time-$start_time;
            if($min_time == null || $min_time > $ellapsed_time) $min_time = $ellapsed_time;
            if($max_time == null || $max_time < $ellapsed_time) $max_time = $ellapsed_time;
            array_push($ellapsed_times, $ellapsed_time);
        }
        // $result = array("sums" => $sums, "times" => $times, "ellapsed_time" => ($end_time-$start_time));
        $result = array("min_time" => $min_time, "max_time" => $max_time, "avg" => array_sum($ellapsed_times) / count($ellapsed_times));
        return $this->json($result);
    }
}