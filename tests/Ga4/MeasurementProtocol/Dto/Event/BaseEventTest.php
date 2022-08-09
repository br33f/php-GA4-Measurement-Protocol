<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 15:05
 */

namespace Tests\Ga4\MeasurementProtocol\Dto\Event;

use BadMethodCallException;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\BaseEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use InvalidArgumentException;
use Tests\Common\BaseTestCase;

class BaseEventTest extends BaseTestCase
{
    /**
     * @var BaseEvent
     */
    protected $event;

    public function testDefaultConstructor()
    {
        $constructedEvent = new BaseEvent();

        $this->assertEquals(null, $constructedEvent->getName());
        $this->assertEquals([], $constructedEvent->getParamList());
    }

    public function testNameOnlyConstructor()
    {
        $setupName = $this->faker->word;
        $constructedEvent = new BaseEvent($setupName);

        $this->assertEquals($setupName, $constructedEvent->getName());
        $this->assertEquals([], $constructedEvent->getParamList());
    }

    public function testParamListOnlyConstructor()
    {
        $baseParams = [];
        for ($i = 0; $i < rand(4, 10); $i++) {
            $baseParams[$this->faker->word] = new BaseParameter($this->faker->word);
        }
        $constructedEvent = new BaseEvent(null, $baseParams);

        $this->assertEquals(null, $constructedEvent->getName());
        $this->assertEquals($baseParams, $constructedEvent->getParamList());
    }

    public function testFullConstructor()
    {
        $setupName = $this->faker->word;

        $baseParams = [];
        for ($i = 0; $i < rand(4, 10); $i++) {
            $baseParams[$this->faker->word] = new BaseParameter($this->faker->word);
        }
        $constructedEvent = new BaseEvent($setupName, $baseParams);

        $this->assertEquals($setupName, $constructedEvent->getName());
        $this->assertEquals($baseParams, $constructedEvent->getParamList());
    }

    public function testName()
    {
        $setupName = $this->faker->word;
        $this->event->setName($setupName);

        $this->assertEquals($setupName, $this->event->getName());
    }

    public function testParamList()
    {
        $baseParams = [];
        for ($i = 0; $i < rand(4, 10); $i++) {
            $baseParams[$this->faker->word] = new BaseParameter($this->faker->word);
        }
        $this->event->setParamList($baseParams);

        $this->assertEquals($baseParams, $this->event->getParamList());
    }

    public function testAddParam()
    {
        $this->event->setParamList([]);

        $paramName = $this->faker->word;
        $paramToAdd = new BaseParameter($this->faker->word);
        $this->event->addParam($paramName, $paramToAdd);

        $this->assertEquals(1, count($this->event->getParamList()));
        $this->assertEquals($paramToAdd, $this->event->getParamList()[$paramName]);
    }

    public function testDeleteParam()
    {
        $this->event->setParamList([]);

        $paramName = $this->faker->word;
        $paramToAdd = new BaseParameter($this->faker->word);
        $this->event->addParam($paramName, $paramToAdd);
        $this->assertEquals(1, count($this->event->getParamList()));

        $this->event->deleteParameter($paramName);
        $this->assertEquals(0, count($this->event->getParamList()));
    }

    public function testExportEmpty()
    {
        $emptyEvent = new BaseEvent();

        $this->assertEquals(['name' => null, 'params' => new \ArrayObject()], $emptyEvent->export());
    }

    public function testExport()
    {
        $setupName = $this->faker->word;

        $baseParamsExport = [];
        $baseParams = [];
        for ($i = 0; $i < rand(4, 10); $i++) {
            $baseParamName = $this->faker->word;
            $baseParam = new BaseParameter($this->faker->word);
            $baseParams[$baseParamName] = $baseParam;
            $baseParamsExport[$baseParamName] = $baseParam->export();
        }
        $constructedEvent = new BaseEvent($setupName, $baseParams);

        $this->assertEquals(['name' => $setupName, 'params' => new \ArrayObject($baseParamsExport)], $constructedEvent->export());
    }

    public function testSetGetCall()
    {
        $this->event->setTest1('test1value');

        $this->assertEquals('test1value', $this->event->getTest1());
    }

    public function testSetCallNoParams()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->event->setTest2();
    }

    public function testUnknownCallMethod()
    {
        $this->expectException(BadMethodCallException::class);
        $this->event->invalidMethodName();
    }

    public function testValidate()
    {
        $setupName = $this->faker->word;

        $baseParams = [];
        for ($i = 0; $i < rand(4, 10); $i++) {
            $baseParam = new BaseParameter($this->faker->word);
            $baseParams[$this->faker->word] = $baseParam;
        }
        $constructedEvent = new BaseEvent($setupName, $baseParams);

        $this->assertTrue($constructedEvent->validate());
    }

    protected function setUp(): void
    {
        $this->event = new BaseEvent();
    }
}
