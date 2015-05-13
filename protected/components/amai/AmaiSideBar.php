<?php

class AmaiSideBar extends CWidget
{
    //Menüeinträge werden hier abgebildet
    public $items = array();

    //Wird das Menü angezeigt?
    public $visible = true;

    //Inhalt der "LightBox" am Anfang des Menüs
    public $lightbox = "";

    function run()
    {
        if ($this->visible) {
            //echo "<section class='row-fluid'>";
            echo "<div class='span2 sideBar'></br>";
            if (!empty($this->lightbox)) {
                echo "<div class='wellLight borBox'>";
                echo $this->lightbox;
                echo "</div>";
                echo "</br>";
            }

            echo "<ul>";
            foreach ($this->items as $item) {
                $this->echoItem($item);
            }
            echo "</ul>";
            echo "</div>";
            // echo "</section>";
        }
    }

    //Ein Item ausgeben
    function echoItem($item, $subitem = false)
    {
        //Prüfen ob das Item überhaupt angezeigt werden soll
        if (!(isset($item['visible']) && $item['visible'] == false)) {

            //Adresse ermitteln
            if (isset($item['url'])) {
                $url = $item['url'];
            } else
                $url = '#';

            //Prüfen ob diese Seite aktiv ist
            $currentControllerPattern = Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;
            if ($this->normalizeUrl(array($currentControllerPattern)) == $this->normalizeUrl($url)) {
                $activeClass = "class='active'";
            } else $activeClass = "";

            //Icon setzen wenn gesetzt
            if (isset($item['icon'])) {
                $icon = "<i class='" . $item['icon'] . "'></i>";
            } else $icon = '';

            //Image setzen wenn gesetzt
            if (isset($item['image'])) {
                $image = CHtml::image(Yii::app()->request->baseUrl . '/img/' . $item['image'], 'IMAGE') . ' ';
            } else $image = '';

            //Beschriftung ermitteln
            if (isset($item['label'])) {
                $label = $item['label'];
            } else $label = '';

            //Divider ermitteln
            if (isset($item['divider'])) {
                $divider = true;
            } else  $divider = false;

            //Badge Warning setzen
            if (isset($item['badge-warning'])) {
                $label = $label . '&nbsp;&nbsp;  <span class="badge badge-warning">' . $item['badge-warning'] . '</span>';
            }

            //Badge Info setzen
            if (isset($item['badge-info'])) {
                $label = $label . '&nbsp;&nbsp;  <span class="badge badge-info">' . $item['badge-info'] . '</span>';
            }

            //Ermitteln ob das ITEM Subitems hat
            if (isset($item['items'])) {
                echo "<li class='dropper'>";
                echo "<figure>";
                echo $icon . " " . $image . " " . $label . '&nbsp;›</figure>';

                //Prüfen ob Subitem aktiv ist
                if ($this->isOneOfSubActive($item['items'])) {
                    $dropstate = "style='display:block'";
                } else $dropstate = "style='display:none'";

                //Menü aufbauen
                echo "<ul class='subSide' $dropstate>";
                foreach ($item['items'] as $subitem) {
                    $this->echoItem($subitem, true);
                }
                echo "</ul>";
                echo "</li>";
            } else {
                //Ausgeben
                if ($divider) {
                    echo "<hr>";
                } else
                    if (!$subitem) {
                        echo "<li $activeClass><figure><a href='" . $this->normalizeUrl($url) . "'>$icon $image $label</a></figure></li>";
                    } else echo "<li $activeClass><a href='" . $this->normalizeUrl($url) . "'>$icon $image $label</a></li>";
            }
        }
    }

    //Normalisiert URLs
    function normalizeUrl($url)
    {
        if (is_array($url)) {
            if (isset($url[0])) {
                if (($c = Yii::app()->getController()) !== null)
                    $url = $c->createUrl($url[0], array_splice($url, 1));
                else
                    $url = Yii::app()->createUrl($url[0], array_splice($url, 1));
            } else
                $url = '';
        }
        return $url === '' ? Yii::app()->getRequest()->getUrl() : $url;
    }

    //Prüft ob eine Subitem Aktiv ist
    function isOneOfSubActive($items)
    {
        foreach ($items as $item) {

            if (isset($item['url'])) {
                $url = $item['url'];
            } else
                $url = '#';

            $currentControllerPattern = Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;
            if ($this->normalizeUrl(array($currentControllerPattern)) == $this->normalizeUrl($url)) {
                return true;
            }
        }
        return false;
    }
}