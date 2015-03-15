<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class SearchForm extends Model
{
    public $search;
    public $file;
    public $filepath;
    public $type;

    public function rules()
    {
        return [
            [['search'], 'required','message'=>''],
            [['file'], 'file'],
            [['file'], 'required','message'=>''],
        	[['file'], 'file', 'extensions' => 'jpg, png, gif, jpeg', 'mimeTypes' => 'image/jpeg, image/png'],
            [['file'], 'file', 'skipOnEmpty' => false],
            [['type'], 'required','message'=>'']
        ];
    }
}