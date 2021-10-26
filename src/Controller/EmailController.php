<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailController extends AbstractController
{
    private $requestStack;

    private function createTextEmail($from, $to, $subject, $text){
        return (new Email())->from($from)
            ->to($to)
            ->subject($subject)
            ->text($text);
    }

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function email(): Response
    {
        $session = $this->requestStack->getSession();
        if($session->get("connected_user")==null)
            return $this->redirectToRoute('login');
        return $this->render('email/test.html.twig', ['user' => $session->get("connected_user")]);
    }
    
    public function send(MailerInterface $mailer): Response
    {
        $mailer->send($this->createTextEmail('zacharie.bossard@up.coop', $_POST["to"], $_POST["subject"], $_POST["mail_body"]));
        return $this->json("ok");
    }
}