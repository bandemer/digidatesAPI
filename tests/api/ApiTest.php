<?php

namespace App\Tests;

class ApiTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\ApiTester
     */
    protected $tester;
    
    protected function _before()
    {
        date_default_timezone_set('UTC');
    }

    protected function _after()
    {
    }

    public function testUnixtime()
    {
        $this->tester->sendGET('/api/v1/unixtime');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['time' => 'integer']);
        $this->tester->seeResponseEquals(json_encode(['time' => time()]));

        $this->tester->sendGET('/api/v1/unixtime?timestamp=Sat, 01 Jan 2022 00:00:00');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['time' => 'integer']);
        $this->tester->seeResponseEquals(json_encode(['time' => 1640995200]));

        $this->tester->sendGET('/api/v1/unixtime?timestamp=2022-01-01 00:00:00');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['time' => 'integer']);
        $this->tester->seeResponseEquals(json_encode(['time' => 1640995200]));

        $this->tester->sendGET('/api/v1/unixtime?timestamp=foo');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['error' => 'string']);
    }

    public function testWeek()
    {
        $this->tester->sendGET('/api/v1/week');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['week' => 'integer']);
        $this->tester->seeResponseEquals(json_encode(['week' => intval(date('W'))]));
    }

    public function testLeapyear()
    {
        $leapyear = (date('L') == 1 ? true : false);
        $this->tester->sendGET('/api/v1/leapyear');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['leapyear' => 'boolean']);
        $this->tester->seeResponseEquals(json_encode(['leapyear' => $leapyear]));
    }

    public function testCheckdate()
    {
        $this->tester->sendGET('/api/v1/checkdate/?date=2022-01-01');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['checkdate' => 'boolean']);
        $this->tester->seeResponseEquals(json_encode(['checkdate' => true]));
    }

    public function testWeekday()
    {
        $this->tester->sendGET('/api/v1/weekday');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['weekday' => 'integer']);
        $this->tester->seeResponseEquals(json_encode(['weekday' => intval(date('w'))]));
    }



    public function testProgress()
    {
        $startTs = strtotime('2022-01-01');
        $endTs = strtotime('2022-12-31');
        $nowTs = time();

        $percent = 100 / ($endTs - $startTs) * ($nowTs - $startTs);

        $this->tester->sendGET('/api/v1/progress?start=2022-01-01&end=2022-12-31');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['float' => 'float', 'percent' => 'integer']);

        $this->tester->seeResponseEquals(json_encode(['float' => ($percent / 100), 'percent' => round($percent)]));
    }

    public function testAge()
    {
        //Not a valid date
        $this->tester->sendGET('/api/v1/age/2022-02-30');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['error' => 'string']);

        //Today should return age 0
        $this->tester->sendGET('/api/v1/age/'.date('Y-m-d'));
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType([
            'age' => 'integer',
            'ageextended' => [
                'years' => 'integer',
                'months' => 'integer',
                'days' => 'integer',
            ],
        ]);

        $this->tester->seeResponseEquals(json_encode([
            'age' => 0,
            'ageextended' => [
                'years' => 0,
                'months' => 0,
                'days' => 0,
            ]
        ]));

        //One Year should return 1 Year
        $this->tester->sendGET('/api/v1/age/'.date('Y-m-d', mktime(0, 0, 0, intval(date('n')), intval(date('j')), intval(date('Y'))-1)));
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType([
            'age' => 'integer',
            'ageextended' => [
                'years' => 'integer',
                'months' => 'integer',
                'days' => 'integer',
            ],
        ]);

        $this->tester->seeResponseEquals(json_encode([
            'age' => 1,
            'ageextended' => [
                'years' => 1,
                'months' => 0,
                'days' => 0,
            ]
        ]));

        //One year, two months and 3 days
        $this->tester->sendGET('/api/v1/age/'.date('Y-m-d', mktime(0, 0, 0, intval(date('n'))-2, intval(date('j'))-3, intval(date('Y'))-1)));
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType([
            'age' => 'integer',
            'ageextended' => [
                'years' => 'integer',
                'months' => 'integer',
                'days' => 'integer',
            ],
        ]);

        $this->tester->seeResponseEquals(json_encode([
            'age' => 1,
            'ageextended' => [
                'years' => 1,
                'months' => 2,
                'days' => 3,
            ]
        ]));
    }

    public function testCo2()
    {
        //No data for years before 1959
        $this->tester->sendGET('/api/v1/co2/1958');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);

        //Test data of 1959
        $this->tester->sendGET('/api/v1/co2/1959');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['co2' => 'float']);
        $this->tester->seeResponseEquals(json_encode(['co2' => 315.98]));

        //Data available for all years from 1959 to last year
        for ($i = 1959; $i < intval(date('Y')); $i++) {
            $this->tester->sendGET('/api/v1/co2/'.$i);
            $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
            $this->tester->seeResponseIsJson();
            $this->tester->seeResponseMatchesJsonType(['co2' => 'float']);
        }

        //No data available for current year
        $this->tester->sendGET('/api/v1/co2/'.date('Y'));
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
    }

    public function testCo2revese()
    {
        $years = [];
        $pattern = '/^([0-9]{4,4}),([0-9]+\.[0-9]{2,2}),.*$/';

        $handle = fopen("docs/co2_annmean_mlo.csv", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $matches = [];
                if (preg_match($pattern, $line,  $matches)) {
                    $years[$matches[1]] = floatval($matches[2]);
                }
            }
            fclose($handle);
        }

        //Test all available values
        foreach ($years AS $y => $v) {
            $this->tester->sendGET('/api/v1/co2/reverse/'.$v);
            $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
            $this->tester->seeResponseIsJson();
            $this->tester->seeResponseMatchesJsonType(['year' => 'integer']);
        }


    }

}