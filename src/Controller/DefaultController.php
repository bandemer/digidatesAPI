<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{
    /**
     * Index
     */
    #[Route(path: '/', name: 'index')]
    public function index(TranslatorInterface $tl) : Response
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title' => $tl->trans('DigiDates.de - API für Datums- und Zeit-Berechnungen'),
            'meta_desc' => $tl->trans('Kostenlose REST API für Datums- und Zeit-Berechnungen.'),
        ];
        return $this->render('sites/index.html.twig',
            ['data' => $data]);
    }

    /**
     * Datenschutz
     */
    #[Route(path: '/datenschutz', name: 'datenschutz')]
    public function datenschutz(TranslatorInterface $tl) : Response
    {
        $data = [
            'meta_robots' => 'noindex,follow',
            'meta_title' => $tl->trans('Datenschutz'),
            'meta_desc' => '',
        ];
        return $this->render('sites/datenschutz.html.twig', ['data' => $data]);
    }

    /**
     * Impressum
     */
    #[Route(path: '/impressum', name: 'impressum')]
    public function impressum(TranslatorInterface $tl) : Response
    {
        $data = [
            'meta_robots' => 'noindex,follow',
            'meta_title' => $tl->trans('Impressum'),
            'meta_desc' => '',
        ];
        return $this->render('sites/impressum.html.twig', ['data' => $data]);
    }

    /**
     * Open API YAML file
     */
    #[Route(path: '/docs/openapi.yaml', name: 'openapi.yaml')]
    public function openapiyaml() : Response
    {
        $output = file_get_contents('../docs/openapi.yaml');
        $r = new Response($output);
        $r->headers->set('Content-Type', 'application/x-yaml');
        $r->headers->set('Access-Control-Allow-Origin', '*');
        $r->headers->set('X-Robots-Tag', 'none');
        return $r;
    }
}