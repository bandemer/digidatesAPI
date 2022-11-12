<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * Index
     * @Route("/", name="index")
     */
    public function index()
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title' => 'DigiDates.de - API für Datums- und Zeit-Funktionen',
            'meta_desc' => 'Kostenlose REST API für Datums- und Zeitfunktionen.',
        ];

        return $this->render('sites/index.html.twig',
            ['data' => $data]);
    }

    /**
     * Open API YAML file
     *
     * @Route("/docs/openapi.yaml", name="openapi.yaml")
     */
    public function openapiyaml()
    {
        $output = file_get_contents('../docs/openapi.yaml');
        $r = new Response($output);
        $r->headers->set('Content-Type', 'application/x-yaml');
        $r->headers->set('Access-Control-Allow-Origin', '*');
        return new Response($output);
    }

    /**
     * Datenschutz
     *
     * @Route("/datenschutz.html", name="datenschutz")
     */
    public function datenschutz()
    {
        $data = [
            'meta_robots' => 'noindex,follow',
            'meta_title' => 'Datenschutz',
            'meta_desc' => '',
        ];

        return $this->render('sites/datenschutz.html.twig', ['data' => $data]);
    }

    /**
     * Impressum
     *
     * @Route("/impressum.html", name="impressum")
     */
    public function impressum()
    {
        $data = [
            'meta_robots' => 'noindex,follow',
            'meta_title' => 'Impressum',
            'meta_desc' => '',
        ];

        return $this->render('sites/impressum.html.twig', ['data' => $data]);
    }
}