<?php

class ColorComponent extends CComponent
{
    /**
     * Init this component
     */
    public function init()
    {


    }

    private function random_color_part()
    {
        return str_pad(dechex(mt_rand(150, 255)), 2, '0', STR_PAD_LEFT);
    }

    public function randomcolor()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }


    function random_color($minVal = 0, $maxVal = 255)
    {

        // Make sure the parameters will result in valid colours
        $minVal = $minVal < 0 || $minVal > 255 ? 0 : $minVal;
        $maxVal = $maxVal < 0 || $maxVal > 255 ? 255 : $maxVal;

        // Generate 3 values
        $r = mt_rand($minVal, $maxVal);
        $g = mt_rand($minVal, $maxVal);
        $b = mt_rand($minVal, $maxVal);

        // Return a hex colour ID string
        return sprintf('%02X%02X%02X', $r, $g, $b);

    }

    function getRandomColor()
    {
        $spread = 25;

        for ($c = 0; $c < 3; ++$c) {
            $color[$c] = rand(0 + $spread, 255 - $spread);
        }

        $r = rand($color[0] - $spread, $color[0] + $spread);
        $g = rand($color[1] - $spread, $color[1] + $spread);
        $b = rand($color[2] - $spread, $color[2] + $spread);
        return $this->RGBToHex($r, $g, $b);

    }

    private function RGBToHex($r, $g, $b)
    {
        $hex = "";
        $hex .= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);

        return $hex;
    }

    function ColorLuminanceHex($hex = 0)
    {
        $hex = str_replace('#', '', $hex);
        $luminance = 0.3 * hexdec(substr($hex, 0, 2)) + 0.59 * hexdec(substr($hex, 2, 2)) + 0.11 * hexdec(substr($hex, 4, 2));
        return $luminance;
    }

}