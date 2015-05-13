<?php

/**
 * Class to generate normally derivated random numbers
 *
 * @author   Andreas Vratny <andreas@vratny.de>
 * @author   Marius Heinemann-Grüder <marius.hg@live.de>
 * @version  0.1
 * @access   public
 */
class RandomComponent extends CComponent
{
    /**
     * Init this component
     */
    public function init()
    {


    }

    /**
     * Generates two normally deviated random numbers with the efficient Polar Method
     */
    public
    function getRandomByPolar($sigma = 1)
    {
        do {
            $y1 = mt_rand() / mt_getrandmax();
            $y2 = mt_rand() / mt_getrandmax();
            $q = pow(2 * $y1 - 1, 2) + pow(2 * $y2 - 1, 2);
        } while ($q > 1);
        $p = sqrt((-2 * log($q)) / $q);
        $z1 = (2 * $y1 - 1) * $p * $sigma;
        $z2 = (2 * $y2 - 1) * $p * $sigma;
        return array($z1, $z2);
    }

    /**
     * Generates two normally deviated random numbers with the Box Mueller Method
     */
    public
    function getRandomByBoxMueller($sigma = 1)
    {
        $u1 = mt_rand() / mt_getrandmax();
        $u2 = mt_rand() / mt_getrandmax();
        $r = sqrt(-2 * log($u1));
        $w = 2 * M_PI * $u2;
        $z1 = $r * cos($w) * $sigma;
        $z2 = $r * sin($w) * $sigma;
        return array($z1, $z2);
    }

    /**
     * Calculates the standard deviation for the given array
     */
    public
    function calcStandardDeviation($valueArray)
    {
        $sum = array_sum($valueArray);
        $count = count($valueArray);
        $mean = $sum / $count;
        $result = 0;
        foreach ($valueArray as $value)
            $result += pow($value - $mean, 2);
        unset($value);
        $count = ($count == 1) ? $count : $count - 1;
        return sqrt($result / $count);
    }


}