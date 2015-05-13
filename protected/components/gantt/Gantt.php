<?php

class Gantt extends CWidget
{

    //Maschinen werden hier abgebildet
    public $items = array();

    public $day = 0;

    function run()
    {
        $uri = Yii::app()->request->baseUrl . '/css/gantt.css';
        Yii::app()->clientScript->registerCssFile($uri);

        echo "<div class='container'>";
        echo $this->getHeadline('hour');
        echo $this->getHeadline('minutes');


        foreach ($this->items as $item) {

            echo "<div class='line''>";
            echo "<div class='machine'><b>[" . $item['ident'] . "] - </b>" . $item['name'] . "</div>";
            $oldItem = null;

            for ($i = 0; $i <= count($item['od']) - 1; $i++) {

                if (!empty($item['od'][$i - 1])) {
                    if ($item['od'][$i]['day_start'] - $item['od'][$i - 1]['day_end'] > 0) {
                        echo $this->getEmptyItem($item['od'][$i - 1]['day_end'], $item['od'][$i]['day_start']);
                    }
                } else {
                    if ($item['od'][$i]['day_start'] > 0) {
                        echo $this->getEmptyItem(0, $item['od'][$i]['day_start']);
                    }
                }

                $product = $item['od'][$i]['product'];
                $simpo = $item['od'][$i]['simpo'];
                $po = $item['od'][$i]['po'];

                $po_string =  $product->number;

                echo $this->getPoItem($item['od'][$i]['sod_id'], $item['od'][$i]['day_start'], $item['od'][$i]['day_end'], $po->order_period . '-' . $po->order_number, $po_string, $item['od'][$i]['color'],$simpo->set_up_time>1);

                /*

                if (($item['po'][$i]['start'] >= ($this->day * 1440)) && ($item['po'][$i]['start'] < (($this->day + 1) * 1440))) {


                    if (!empty($item['po'][$i - 1])) {
                        if ($item['po'][$i]['start'] - $item['po'][$i - 1]['end']  > 0) {
                            echo $this->getEmptyItem($item['po'][$i - 1]['end'], $item['po'][$i]['start']);
                        }
                    } else {
                        if ($item['po'][$i]['start'] > 0) {
                            echo $this->getEmptyItem(0, $item['po'][$i]['start']);
                        }
                    }


                    if (($item['po'][$i]['end'] / 1440) <= ($this->day + 1)) {
                        echo $this->getPoItem($item['po'][$i]['start'], $item['po'][$i]['end'], $item['po'][$i]['id'], 'a',$item['po'][$i]['color']);

                    } else {
                        echo $this->getPoItem($item['po'][$i]['start'], ($this->day + 1) * 1440, $item['po'][$i]['id'], 'b',$item['po'][$i]['color']);
                    }
                }
                else if (($item['po'][$i]['end'] > ($this->day * 1440)) && ($item['po'][$i]['end'] < (($this->day + 1) * 1440)))
                {
                    if ($item['po'][$i]['start'] < ($this->day * 1440))
                    {
                        echo $this->getPoItem(($this->day) * 1440, $item['po'][$i]['end'], $item['po'][$i]['id'], 'c',$item['po'][$i]['color']);
                    }
                }
                */

            }
            echo "</div><br>";
        }

        echo "</div>";
    }

    //Private Einzelmethoden

    function getHeadline($option)
    {
        $headline = '';
        $headline .= "<div class='headline''>";
        $headline .= "<div class='topruler'></div>";
        switch ($option) {
            case "day":
                // Tag ergänzen
                break;
            case "hour":
                for ($i = 0; $i <= 23; $i++) {
                    $headline .= "<div class='head-hours'>" . $i . "</div>";
                }
                break;
            case "minutes":
                for ($i = 0; $i <= 23; $i++) {
                    $headline .= "<div class='head-minutes'>15</div>";
                    $headline .= "<div class='head-minutes'>30</div>";
                    $headline .= "<div class='head-minutes'>45</div>";
                    $headline .= "<div class='head-minutes'>00</div>";
                }
                break;
        }

        $headline .= "</div>";
        return $headline . "<br>";
    }


    function getPoItem($sod_id, $start, $end, $ident, $part, $color, $rüst = false)
    {
        $po = "";
        if ($start > $end) {

        }
        $width = floor(($end - $start) * 3);

        $luminance = Yii::app()->color->ColorLuminanceHex($color);
        if ($luminance < 128) {
            $compColor = 'FFFFFF';
        } else {
            $compColor = '000000';
        }


        $po .= " <div tooltip='" . $sod_id . "' class='po_time' style='border:1px solid #666666; background:#" . $color . ";min-width:" . $width . "px; max-width: " . $width . "px'>";
        $po .= "<span style='color:#" . $compColor . ";'>";
        $po .= $ident . "<br>";
        $po .= $part . "<br>";
        if ($rüst) {
            $po .= 'R';
        }
        $po .= "</span>";
        $po .= "</div>";
        return $po;
    }

    function getEmptyItem($start, $end)
    {
        $e = "";
        $width = floor(($end - $start) * 3);
        $e .= " <div class='idle_time' style='min-width:" . $width . "px; max-width: " . $width . "px'></div>";
        return $e;
    }
}
