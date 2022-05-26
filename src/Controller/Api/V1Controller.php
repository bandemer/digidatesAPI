<?php

namespace App\Controller\Api;

use App\Service\DateAndTimeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class V1Controller extends AbstractController
{
    /**
     * UnixTime
     * @Route("/api/v1/unixtime/{timestamp}", methods={"GET"})
     */
    public function unixtime(string $timestamp = ''): JsonResponse
    {
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
     * Kalenderwoche
     * @Route("/api/v1/week/{timestamp}")
     */
    public function week(DateAndTimeService $dts, string $timestamp = ''): JsonResponse
    {
        $kw = $dts->week($timestamp);

        return $this->json(
            ['week' => $kw],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * Schaltjahr
     * @Route("/api/v1/leapyear/{timestamp}", methods={"GET"})
     */
    public function leapyear(DateAndTimeService $dts, string $timestamp = ''): JsonResponse
    {
        $leapYear = $dts->leapYear($timestamp);

        return $this->json(
            ['leapyear' => $leapYear],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * Gültiges Datum?
     * @Route("/api/v1/checkdate/{date}", methods={"GET"})
     */
    public function checkdate(DateAndTimeService $dts, string $date = ''): JsonResponse
    {
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
     * Wochentag
     * @Route("/api/v1/weekday/{date}", methods={"GET"})
     */
    public function weekday(DateAndTimeService $dts, string $date = ''): JsonResponse
    {
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
     * Progress
     * @Route("/api/v1/progress/{start}/{end}", methods={"GET"})
     */
    public function progress(DateAndTimeService $dts, $start, $end): JsonResponse
    {
        $val = $dts->progress($start, $end);

        return $this->json(
            ['float' => $val, 'percent' => round($val / 100 * 100)], 200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

}