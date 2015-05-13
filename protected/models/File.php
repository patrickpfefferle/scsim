<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 07.08.14
 * Time: 12:02
 */

class File extends CFormModel
{
    public $inputFile;


    public function rules()
    {
        return array(
            array('inputFile', 'file', 'types'=>'txt'),
        );
    }
}