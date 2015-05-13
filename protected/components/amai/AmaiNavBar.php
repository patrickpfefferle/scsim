<?php

/**
 * AmaiNavBar provides php access to the header menu of amai template
 *
 * @author   Andreas Vratny <andreas@vratny.de>
 * @author   Marius Heinemann-Grüder <marius.hg@live.de>
 * @version  1.2
 * @access   public
 */
class AmaiNavBar extends CWidget
{
    //Menüeinträge werden hier abgebildet
    public $items = array();
    //Einstellungen wie Logo wird hier abgebildet
    public $settings = array();

    function run()
    {
        echo "<div class='navbar-inner'>";
        echo "<div class='container-fluid'>";

        if (isset($this->settings['pagetitle'])) {
            $pagetitle = $this->settings['pagetitle'];
        } else $pagetitle = 'not configured';

        echo "<a href='".$this->normalizeUrl(array('site/index'))."' class='brand pull-left'><i class='icon-white icon-'></i>  " . $pagetitle . "</a>";

        //Navigation aufbauen (linke Seite)

        echo "<ul class='nav pull-left'>";
        foreach ($this->items as $item) {
            if (!isset($item['orientation']) || $item['orientation'] == 'left') {
                $this->echoItem($item);
            }
        }
        echo "</ul>";

        // Navigation aufbauen (rechte Seite)
        echo "<ul class='nav pull-right'>";
        foreach ($this->items as $item) {
            if (isset($item['orientation']) && $item['orientation'] == 'right') {
                $this->echoItem($item);
            }
        }
        echo "</ul>";

        echo "</div>";
        echo "</div>";
    }

    //Ein Item ausgeben
    function echoItem($item)
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
                $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/'.$item['image'], 'IMAGE').' ';
            } else $image = '';

            //Flagge bei Übersetzung setzen
            if(isset($item['flag']))
            {
                $flagcode=trim($item['flag']);
                switch($flagcode)
                {
                    case "de": $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/flag_germany.png', 'IMAGE').' ';
                        break;
                    case "es": $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/flag_spain.png', 'IMAGE').' ';
                        break;
                    case "en": $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/flag_united_kingdom.png', 'IMAGE').' ';
                        break;
                    case "fr": $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/flag_france.png', 'IMAGE').' ';
                        break;
                    case "it": $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/flag_italy.png', 'IMAGE').' ';
                        break;
                    case "ja": $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/flag_japan.png', 'IMAGE').' ';
                        break;
                    case "pl": $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/flag_poland.png', 'IMAGE').' ';
                        break;
                    case "ru": $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/flag_russia.png', 'IMAGE').' ';
                        break;
                    case "el": $image =  CHtml::image(Yii::app()->request->baseUrl.'/img/flag_greece.png', 'IMAGE').' ';
                        break;
                    default: break;
                }
                $flagonclick='onclick="changeLang(\''.trim($flagcode).'\')"';
            } else $flagonclick='';


            //Beschriftung ermitteln
            if (isset($item['label'])) {
                $label = $item['label'];
            } else $label = '';


            //Wenn vorhanden Tooltipp setzen
            if (isset($item['tooltip'])) {
                $tooltip = "rel='tooltip' title='" . $item['tooltip'] . "'";
            } else $tooltip = '';

            //Badge setzen
            if (isset($item['badge'])) {
                $label = $label . '  <span class="badge badge-nav">' . $item['badge'] . '</span>';
            }

            //Ermitteln ob das ITEM Subitems hat
            if (isset($item['items'])) {
                echo "<li class='dropdown'>";
                echo "<a href='#' " . $tooltip . " class='dropdown-toggle' data-toggle='dropdown'>";
                echo "$icon $image $label" . '<b class="caret"></b>';
                echo "</a>";
                //Menü aufbauen
                echo "<ul class='dropdown-menu'>";
                foreach ($item['items'] as $subitem) {
                    $this->echoItem($subitem);
                }
                echo "</ul>";
                echo "</li>";
            } else {
                //Ausgeben
                echo "<li $flagonclick $activeClass><a href='" . $this->normalizeUrl($url) . "' " . $tooltip . ">$icon $image $label</a></li>";
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
}