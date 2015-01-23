<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImagesearchForm extends Model
{
    public $file;
    public $filepath;
    public $type;

    public function rules()
    {
        return [
        	[['file'], 'file'],
        	[['file'], 'file', 'extensions' => 'jpg, png, gif, jpeg', 'mimeTypes' => 'image/jpeg, image/png'],
            [['file'], 'file', 'skipOnEmpty' => false],
            [['type'], 'required']
        ];
    }
}