<?php

namespace App\Controller;

use App\Service\DateAndTimeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * UnixTime
     * @param string $timestamp
     * @return JsonResponse     *
     * @Route("/unixtime/{timestamp}", name="unixtime", methods={"GET"})
     */
    public function unixtime(string $timestamp = '')
    {
        $unixTime = time();
        if ($timestamp != '') {

            $unixTime = strtotime($timestamp);
        }

        return $this->json(['time' => $unixTime]);
    }

    /**
     * Kalenderwoche
     * @param DateAndTimeService $dts
     * @param string $timestamp
     * @return JsonResponse
     * @Route("/week/{timestamp}", name="week", methods={"GET"})     *
     */
    public function week(DateAndTimeService $dts, string $timestamp = '')
    {
        $kw = $dts->week($timestamp);

        return $this->json(['week' => $kw]);
    }

    /**
     * Schaltjahr
     * @param DateAndTimeService $dts
     * @param string $timestamp
     * @return JsonResponse
     * @Route("/leapyear/{timestamp}", name="leapyear", methods={"GET"})
     */
    public function leapyear(DateAndTimeService $dts, string $timestamp = '')
    {
        $leapYear = $dts->leapYear($timestamp);

        return $this->json(['leapyear' => $leapYear]);
    }

    /**
     * Gültiges Datum?
     * @param DateAndTimeService $dts
     * @param string $date
     * @return JsonResponse
     * @Route("/checkdate/{date}", name="checkdate", methods={"GET"})
     */
    public function checkdate(DateAndTimeService $dts, string $date = '')
    {
        $returnBool = $dts->checkdate($date);

        if (is_null($returnBool)) {
            return new Response('Bad Request', 500);
        }

        return $this->json(['checkdate' => $returnBool]);
    }

    /**
     * Wochentag
     *
     * @Route("/weekday/{date}", name="weekday", methods={"GET"})
     */
    public function weekday(DateAndTimeService $dts, string $date = '')
    {
        $ts = $dts->weekday($date);

        if ($ts > 0) {
            $returnInt = (int) date('w', $ts);
            return $this->json(['weekday' => $returnInt]);
        } else {
            return new Response('Bad Request', 500);
        }
    }

}