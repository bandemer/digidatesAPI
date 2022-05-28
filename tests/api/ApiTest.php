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
}