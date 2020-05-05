<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/unixtime", name="unixtime")
     */
    public function unixTime()
    {
        return $this->json(['time' => time()]);
    }

    /**
     * @Route("/kw", name="kw")
     */
    public function kw()
    {
        return $this->json(['kw' => date('W')]);
    }
}