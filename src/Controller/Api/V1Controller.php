<?php

namespace App\Controller\Api;

use App\Service\DateAndTimeService;
use Cassandra\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class V1Controller extends AbstractController
{
    /**
     * UnixTime
     * @param string $timestamp
     * @return JsonResponse     *
     * @Route("/api/v1/unixtime/{timestamp}", name="unixtime", methods={"GET"})
     */
    public function unixtime(string $timestamp = '')
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
     * @param DateAndTimeService $dts
     * @param string $timestamp
     * @return JsonResponse
     * @Route("/api/v1/week/{timestamp}", name="week", methods={"GET"})     *
     */
    public function week(DateAndTimeService $dts, string $timestamp = '')
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
     * @param DateAndTimeService $dts
     * @param string $timestamp
     * @return JsonResponse
     * @Route("/api/v1/leapyear/{timestamp}", name="leapyear", methods={"GET"})
     */
    public function leapyear(DateAndTimeService $dts, string $timestamp = '')
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
     * @param DateAndTimeService $dts
     * @param string $date
     * @return JsonResponse
     * @Route("/api/v1/checkdate/{date}", name="checkdate", methods={"GET"})
     */
    public function checkdate(DateAndTimeService $dts, string $date = '')
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
     * @param DateAndTimeService $dts
     * @param string $date
     * @return JsonResponse
     * @Route("/api/v1/weekday/{date}", name="weekday", methods={"GET"})
     */
    public function weekday(DateAndTimeService $dts, string $date = '')
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
     * @param DateAndTimeService $dts
     * @param string $date
     * @return JsonResponse
     * @Route("/api/v1/progress/{start}/{end}", name="weekday", methods={"GET"})
*/
    public function progress(DateAndTimeService $dts, $start, $end = null)
    {
        return $this->json(
            ['float' => 0.5, 'percent' => 50],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

}