<?php


namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FrontendController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('app.twig');
    }
}