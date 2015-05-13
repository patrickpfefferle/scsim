<?php

class AmaiPageHeader extends CWidget
{
    public $header = '';

    public $subtitle = '';

    function run()
    {
        echo '<div class="page-header" >';
        echo "<h1 > $this->header  <small > $this->subtitle </small ></h1>";
        echo '</div >';
    }
}