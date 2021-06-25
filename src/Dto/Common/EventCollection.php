<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 13:51
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto\Common;


use Br33f\Ga4\MeasurementProtocol\Dto\Event\AbstractEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\ExportableInterface;
use Br33f\Ga4\MeasurementProtocol\Dto\ValidateInterface;
use Br33f\Ga4\MeasurementProtocol\Enum\ErrorCode;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use InvalidArgumentException;

class EventCollection implements ExportableInterface, ValidateInterface
{
    /**
     * @var AbstractEvent[]
     */
    protected $eventList = [];

    /**
     * @param AbstractEvent $event
     */
    public function addEvent(AbstractEvent $event)
    {
        if (count($this->eventList) >= 25) {
            throw new InvalidArgumentException('Event list must not exceed 25 items', ErrorCode::MAX_EVENT_COUNT_EXCEED);
        }

        $this->eventList[] = $event;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        return array_map(function ($userProperty) {
            return $userProperty->export();
        }, $this->getEventList());
    }

    /**
     * @return array
     */
    public function getEventList(): array
    {
        return $this->eventList;
    }

    /**
     * @param array $eventList
     */
    public function setEventList(array $eventList)
    {
        if (count($eventList) > 25) {
            throw new InvalidArgumentException('Event list must not exceed 25 items', ErrorCode::MAX_EVENT_COUNT_EXCEED);
        }

        $this->eventList = $eventList;
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        if (count($this->getEventList()) === 0) {
            throw new ValidationException('Event list must not be empty', ErrorCode::VALIDATION_EVENTS_MUST_NOT_BE_EMPTY, 'events');
        }

        return true;
    }
}