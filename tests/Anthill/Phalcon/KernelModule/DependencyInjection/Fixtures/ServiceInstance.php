<?php

namespace Tests\Anthill\Phalcon\KernelModule\DependencyInjection\Fixtures;

class ServiceInstance
{

    private $paramA;
    private $paramB;
    private $paramC;
    public $paramD;
    public $paramE;
    public static $number = 0;

    public function __construct($paramA, $paramB)
    {
        self::$number++;
        $this->paramA = $paramA;
        $this->paramB = $paramB;
    }

    public function setC($paramC)
    {
        $this->paramC = $paramC;
    }

    /**
     * @return mixed
     */
    public function getParamA()
    {
        return $this->paramA;
    }

    /**
     * @return mixed
     */
    public function getParamB()
    {
        return $this->paramB;
    }

    /**
     * @return mixed
     */
    public function getParamC()
    {
        return $this->paramC;
    }

    /**
     * @return mixed
     */
    public function getParamD()
    {
        return $this->paramD;
    }

    /**
     * @return mixed
     */
    public function getParamE()
    {
        return $this->paramE;
    }
}