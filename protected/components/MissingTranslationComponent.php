<?php

class MissingTranslationComponent
{

    public static function logMissingData($event)
    {
        //in der Liste fehlt en, weil dies "Standard" ist
        $lang = Yii::app()->params['availableLanguage'];

        $source_count = SourceInformation::model()->count('category=:c and message=:m', array(':c' => $event->category, ':m' => $event->message));
        if ($source_count <= 0) {
            $source = new SourceInformation();
            $source->message = $event->message;
            $source->category = $event->category;
            $source->save();
        } else {
            $source = SourceInformation::model()->find('category=:c and message=:m', array(':c' => $event->category, ':m' => $event->message));
        }

        if (isset($source)) {
            foreach ($lang as $lcode) {
                $translated_count = TranslatedInformation::model()->count('id=:id and language=:l', array(':id' => $source->id, ':l' => $lcode));
                if ($translated_count <= 0) {
                    $translated = new TranslatedInformation();
                    $translated->id = $source->id;
                    $translated->language = $lcode;
                    $translated->save();
                }
            }
        }


        Yii::log('Language: ' . $event->language . ' Category: ' . $event->category . ' Message: ' . $event->message);
    }
}