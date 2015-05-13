<?php

define('PRIMARY_SORT_PROP', '_executionTime');
define('SECONDARY_SORT_PROP', '_eventNumber');

/**
 * Class Sim
 * Central class of Framework
 */
class SimFrame
{
    /**
     * @var Current simulation time
     */
    private $_currentSimTime;

    /**
     * @var Maximum simulation time
     */
    private $_endSimTime;

    /**
     * @var array Events of Simulation
     */
    public $_eventList = array();

    /**
     * @var This function will be called by simulation if a event executes
     */
    private $_eventCallBackFunction;

    /**
     * @var Current Event Number
     */
    private $lastEventNumber;

    /**
     * @var Objects that are important for full Simulation
     */
    private $_objects = array();

    /**
     * @var bool Muss neu sortiert werden?
     */
    private $_hasToSort = true;

    private $_sortEventArray = array(PRIMARY_SORT_PROP, SECONDARY_SORT_PROP);

    /**
     *
     */
    private $_addedSmalestSimTime = -1;

    /**********************************/

    /**
     * Get the current time in Simulation
     */
    public function getCurrentSimTime()
    {
        return $this->_currentSimTime;
    }

    /**
     * @param \This $eventCallBackFunction
     */
    public function setEventCallBackFunction($eventCallBackFunction)
    {
        $this->_eventCallBackFunction = $eventCallBackFunction;
    }

    /**
     * @return \This
     */
    public function getEventCallBackFunction()
    {
        return $this->_eventCallBackFunction;
    }

    public function init()
    {
        // Yii Kompatibilität
    }

    /**********************************/


    private function sort_events_by_time(&$exectime)
    {
        Yii::beginProfile('Events sortieren');
        $tmp = &$this->_sortEventArray;
        usort($exectime, function ($a, $b) use ($tmp) {
            if ($a->$tmp[0] == $b->$tmp[0])
                return $a->$tmp[1] > $b->$tmp[1] ? 1 : -1;
            return $a->$tmp[0] > $b->$tmp[0] ? 1 : -1;
        });
        Yii::endProfile('Events sortieren');
    }

    /**
     *  Starts the simulation
     */
    function startSimulate($endSimTime)
    {
        $this->_endSimTime = $endSimTime;

        function compareEvents($a, $b)
        {
            return $a->getExecutionTime() - $b->getExecutionTime();
        }


        //sort events
        $this->sort_events_by_time($this->_eventList);
        $this->_addedSmalestSimTime = $endSimTime;
        // $datei = fopen("counter.txt","a+");
        while (count($this->_eventList) > 0 && $this->_currentSimTime < $this->_endSimTime) {

            $currentEvent = array_shift($this->_eventList);
            //  fwrite($datei, $currentEvent->_executionTime.' - '.$currentEvent->getEventNumber()."\r\n");
            $this->_currentSimTime = $currentEvent->getExecutionTime();

            call_user_func_array($this->_eventCallBackFunction, array('event' => $currentEvent, 'simtime' => $this->_currentSimTime, 'sim' => $this));

            if (count($this->_eventList) > 0) {
                if ($this->_addedSmalestSimTime <= $this->_eventList[0]->_executionTime && $this->_hasToSort == true) {
                    //sort events
                    $this->sort_events_by_time($this->_eventList);
                    $this->_hasToSort = false;
                }
            }
        }
        // fclose($datei);
    }

    /**
     * @param $event
     */
    function addEvent($event)
    {
        $event->setEventNumber($this->lastEventNumber + 1);
        $this->lastEventNumber = $this->lastEventNumber + 1;
        $this->_eventList[] = $event;
        $this->_hasToSort = true;

        if ($this->_addedSmalestSimTime >= $event->_executionTime) {
            $this->_addedSmalestSimTime = $event->_executionTime;
        }
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
}