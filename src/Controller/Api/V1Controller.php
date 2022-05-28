<?php

namespace App\Controller\Api;

use App\Service\DateAndTimeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class V1Controller extends AbstractController
{
    /**
     * UnixTime
     * @Route("/api/v1/unixtime", methods={"GET"})
     */
    public function unixtime(Request $req): JsonResponse
    {
        $timestamp = $req->get('timestamp', '');
        $unixTime = time();
        if ($timestamp != '') {
            $unixTime = strtotime($timestamp);
        }

        return $this->json(
            ['time' => $unixTime],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * ISO week date
     *
     * @Route("/api/v1/week")
     */
    public function week(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $date = $req->get('date', '');
        $kw = $dts->week($date);

        return $this->json(
            ['week' => $kw],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * Schaltjahr
     * @Route("/api/v1/leapyear", methods={"GET"})
     */
    public function leapyear(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $year = $req->get('year', '');
        $leapYear = $dts->leapYear($year);

        return $this->json(
            ['leapyear' => $leapYear],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * Is ist a valid Date?
     *
     * @Route("/api/v1/checkdate", methods={"GET"})
     */
    public function checkdate(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $date = $req->get('date', '');
        $returnBool = $dts->checkdate($date);

        if (is_null($returnBool)) {
            return $this->json(
                'Bad Request',
                500,
                ['Access-Control-Allow-Origin' => '*']
            );
        }

        return $this->json(
            ['checkdate' => $returnBool],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * Day of Week
     *
     * @Route("/api/v1/weekday", methods={"GET"})
     */
    public function weekday(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $date = $req->get('date', '');
        $ts = $dts->weekday($date);

        if ($ts > 0) {
            $returnInt = (int) date('w', $ts);
            return $this->json(
                ['weekday' => $returnInt],
                200,
                ['Access-Control-Allow-Origin' => '*']
            );
        } else {
            return $this->json('Bad Request',
                500,
                ['Access-Control-Allow-Origin' => '*']
            );
        }
    }

    /**
     * reached progress from one timestamp to another
     *
     * @Route("/api/v1/progress", methods={"GET"})
     */
    public function progress(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $start = $req->get('start', '');
        $end = $req->get('end', '');
        $val = $dts->progress($start, $end);

        return $this->json(
            ['float' => $val, 'percent' => round($val / 100 * 100)], 200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

}