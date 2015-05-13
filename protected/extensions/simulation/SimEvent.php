<?php

/**
 * Class SimEvent
 * Base class for events
 */
class SimEvent
{
    /**
     * @var Will execute this event on this time
     */
    public $_executionTime;

    /**
     * @var Which event is this?
     */
    public $_typeOfEvent;

    /**
     * @var Objects that are important for this event
     */
    private $_objects = array();

    /**
     * @var Key Value Pair
     */
    private $_keyvalue = array();

    /**
     * @var ID of an Event
     */
    private $_eventID;

    /**
     * @var Sequencial number
     */
    public $_eventNumber;

    /**
     * @param \Sequencial $eventNumber
     */
    public function setEventNumber($eventNumber)
    {
        $this->_eventNumber = $eventNumber;
    }

    /**
     * @return \Sequencial
     */
    public function getEventNumber()
    {
        return $this->_eventNumber;
    }


    /********************************************/
    public function init()
    {
        // Yii Kompatibilität
    }

    /**
     * @param \Will $executionTime
     */
    public function setExecutionTime($executionTime)
    {
        $this->_executionTime = $executionTime;
    }

    /**
     * @return \Will
     */
    public function getExecutionTime()
    {
        return $this->_executionTime;
    }

    /**
     * @param \Which $typeOfEvent
     */
    public function setTypeOfEvent($typeOfEvent)
    {
        $this->_typeOfEvent = $typeOfEvent;
    }

    /**
     * @return \Which
     */
    public function getTypeOfEvent()
    {
        return $this->_typeOfEvent;
    }

    /**
     * @return \ID
     */
    public function getEventID()
    {
        return $this->_eventID;
    }


    /********************************************/

    function __construct()
    {
        $this->_eventID = 'event-' . md5(uniqid('', true));
    }

    /**
     * @param $object
     * @return mixed
     */
    function addObject($object)
    {
        //Check that this Object is already a member
        foreach ($this->_objects as $o) {
            if ($o == $object) {
                return $o;
            }
        }
        $this->_objects[] = $object;
        return $object;
    }

    /**
     * If no object is found it will return false
     * @param $className
     * @return mixed
     */
    function getObject($className)
    {
        foreach ($this->_objects as $o) {
            if (is_a($o, $className)) {
                return $o;
            }
        }
        return false;
    }

    function getValue($Key)
    {
        return $this->_keyvalue[$Key];
    }

    function setValue($Key, $Value)
    {
        $this->_keyvalue[$Key] = $Value;
    }

    function executeLast()
    {
        $this->_eventNumber = 9999999;
    }

}