<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\widgets\ActiveForm;
use yii\web\View;
/* @var $this yii\web\View */
$this->title = 'Pest and Diseases Identification System';
$this->registerJs("
$('document').ready(function(){
    $('#image-search-form').hide();
    $('#show-image-form').click(function(){
        $('#image-search-form').show();
        $('#text-search-form').hide();   
    });
    $('#show-text-form').click(function(){
        $('#image-search-form').hide();
        $('#text-search-form').show();   
    });
});
function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#preview')
            .attr('src', e.target.result)
            .width(300)
            .height(200);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }",View::POS_END, 'my-options'
);
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>APADIS</h1>

        <?php $form = ActiveForm::begin(['options' =>['id'=>'text-search-form','class'=>'form-inline']]); ?>
                <?= $form->field($model, 'search')->textInput(["style"=>"width:700px !important;"]) ?>
                <button id="show-image-form" type="button" class="btn btn-default btn-sm" style="padding: 5px 24px !important;">
                  <span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
                </button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', ['class' => 'btn btn-sm btn-primary','style'=>'padding: 5px 24px !important;']) ?>
        <?php ActiveForm::end(); ?>

        <?php $form = ActiveForm::begin(['options' => ['id'=>'image-search-form','class'=>'form-inline','enctype' => 'multipart/form-data'] ]);?>
                <?= $form->field($model, 'file')->fileInput(["onchange"=>"readURL(this);","style"=>"width:575px !important;"]); ?>
                <?= $form->field($model,'type')->radioList(["pest"=>"Pest","disease"=>"Disease"]); ?>
                <button id="show-text-form" type="button" class="btn btn-default btn-sm" style="padding: 5px 24px !important;">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', ['class' => 'btn btn-sm btn-primary','style'=>'padding: 5px 24px !important;']) ?>
        <?php ActiveForm::end(); ?>
        <img id="preview" src="" />
    </div>

    <div class="body-content">


    </div>
</div>
