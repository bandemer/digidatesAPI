<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\StatistikService;
use MatomoTracker;

class StatistikController extends AbstractController
{
    /**
     * @Route("/st", name="statistik")
     */
    public function statistik(Request $req, StatistikService $statistikService): JsonResponse
    {
        $pageUrl = $req->get('pu', '');
        $pageTitle = $req->get('pt', '');
        $screenWidth = $req->get('sw', 0);
        $screenHeight = $req->get('sh', 0);

        if ($pageUrl != '' AND
            $pageTitle != '' AND $screenWidth > 0 AND $screenHeight > 0) {

            $matomoTracker = new MatomoTracker((int) $statistikService->getSiteid(), $statistikService->getUrl());
            $matomoTracker->setTokenAuth($statistikService->getToken());
            $matomoTracker->disableCookieSupport();
            $matomoTracker->setUrl($pageUrl);
            $matomoTracker->setResolution($screenWidth, $screenHeight);
            $matomoTracker->doTrackPageView($pageTitle);
        }

        return new JsonResponse(['status' => 'OK']);
    }

}