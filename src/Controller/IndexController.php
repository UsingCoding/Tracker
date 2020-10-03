<?php


namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function index(): Response
    {
        $dbconn = pg_connect("host=db dbname=main user=root password=1234");

        /** @var Connection $connection */
        $connection = $this->getDoctrine()->getConnection();

//        $connection->prepare('SELECT * FROM main');

        return new Response(gettype($connection));
    }
}