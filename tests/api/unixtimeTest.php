<?php

namespace App\Tests;

class unixtimeTest extends \Codeception\Test\Unit
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

    }

    public function testWeek()
    {
        $this->tester->sendGET('/api/v1/week');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['week' => 'integer']);

    }

    public function testLeapyear()
    {
        $this->tester->sendGET('/api/v1/leapyear');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['leapyear' => 'boolean']);

    }

    public function testCheckdate()
    {
        $this->tester->sendGET('/api/v1/checkdate/2020-01-01');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['checkdate' => 'boolean']);

    }

    public function testWeekday()
    {
        $this->tester->sendGET('/api/v1/weekday');
        $this->tester->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseMatchesJsonType(['weekday' => 'integer']);

    }
}