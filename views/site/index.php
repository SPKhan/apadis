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
    $('#submit-pest').click(function(){
        $('input[name=\"SearchForm[type]\"][value=\"pest\"]').prop('checked',true);
        $('#text-search-form').submit();
    });
    $('#submit-disease').click(function(){
        $('input[name=\"SearchForm[type]\"][value=\"disease\"]').prop('checked',true);
        $('#text-search-form').submit();
    });
    $('#submit-pest-image').click(function(){
        $('input[name=\"SearchForm[type]\"][value=\"pest\"]').prop('checked',true);
        $('#image-search-form').submit();
    });
    $('#submit-disease-image').click(function(){
        $('input[name=\"SearchForm[type]\"][value=\"disease\"]').prop('checked',true);
        $('#image-search-form').submit();
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
    }
",View::POS_END, 'my-options'
);
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
                <?= $form->field($model, 'file')->fileInput(["onchange"=>"readURL(this);","style"=>"width:700px !important;","class"=>"form-control"]); ?>
                <button id="show-text-form" type="button" class="btn btn-default btn-sm" style="padding: 5px 24px !important;">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
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
