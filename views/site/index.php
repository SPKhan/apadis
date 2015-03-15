<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\widgets\ActiveForm;
use yii\web\View;
/* @var $this yii\web\View */
$this->title = 'Pest and Diseases Identification System';
$this->registerJsFile(BaseUrl::base().'/js/main.js',['depends' => [yii\web\JqueryAsset::className()]]);
?>
<div class="site-index">

    <div class="jumbotron" style="padding-top:0px!important;">
        <img src="<?php echo BaseUrl::base(); ?>/logo.png" width="700px" height="200px"/>

        <?php $form = ActiveForm::begin(['options' =>['id'=>'text-search-form','class'=>'form-inline']]); ?>
            <div class="form-group">
                <?= $form->field($model, 'search')->textInput(["style"=>"width:700px !important;"]) ?>
                <button id="show-image-form" type="button" class="btn btn-default btn-sm" style="padding: 5px 24px !important;">
                  <span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
                </button>

                <?= $form->field($model,'type')->radioList(["pest"=>"Pest","disease"=>"Disease"],['hidden'=>'hidden']); ?>
            </div>
            <br/>
            <?= Html::button('Pests', ['id'=>'submit-pest','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>

            <?= Html::button('Diseases', ['id'=>'submit-disease','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>
        <?php ActiveForm::end(); ?>

        <?php $form = ActiveForm::begin(['options' => ['hidden'=>'hidden','id'=>'image-search-form','class'=>'form-inline','enctype' => 'multipart/form-data'] ]);?>
                <div class='input-container row'>

                        <div class='imagesearch-upper'>

                            <div class='button-close'>
                                <span id="show-text-form" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </div>

                            <p class='imagesearch-head' >Search by Image</p>
                            <p class='imagesearch-desc'>Search APADIS with an image instead of text.</p>
                        
                        </div>

                            <?= $form->field($model, 'file')->fileInput(["onchange"=>"readURL(this);","style"=>"width:900px !important;"]); ?>
                </div>
                <?= $form->field($model,'type')->radioList(["pest"=>"Pest","disease"=>"Disease"],['hidden'=>'hidden']); ?>
                <br/>
                <?= Html::button('Pests', ['id'=>'submit-pest-image','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>

                <?= Html::button('Diseases', ['id'=>'submit-disease-image','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>
        <?php ActiveForm::end(); ?>

        <br/><br/>
        <img id="preview" src="" />
    </div>
    

    <div class="body-content">


    </div>
</div>
