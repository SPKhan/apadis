<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\widgets\ActiveForm;
use yii\web\View;
/* @var $this yii\web\View */
$this->title = 'Pest and Diseases Search Results';
$this->registerJs('
	$("document").ready(function() {
		$("#image-search-form").hide();
	    $("#show-image-form").click(function(){
	        $("#image-search-form").show();
	        $("#text-search-form").hide();   
	    });
	    $("#show-text-form").click(function(){
	        $("#image-search-form").hide();
	        $("#text-search-form").show();   
		});
	$(".wrap > .container").attr("style","padding:0px 15px 20px !important;");
});',View::POS_END, 'my-options');
if($model->file){
$this->registerJsFile(BaseUrl::base().'/js/jquery.jqplot.min.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJs('
	$("document").ready(function() {
		$("#image-search-form").hide();
	    $("#show-image-form").click(function(){
	        $("#image-search-form").show();
	        $("#text-search-form").hide();   
	    });
	    $("#show-text-form").click(function(){
	        $("#image-search-form").hide();
	        $("#text-search-form").show();   
		});
		$(".wrap > .container").attr("style","padding:0px 15px 20px !important;");
	$.ajax({
		type:"POST",
		url:"http://127.0.0.1:5000/imageSearch",
		dataType:"json",
		data: 
			{
				filename:"../web/'.$model->filepath.'",
				type: "'.$model->type.'"
			},
		success: function(result){
			var result_container = $("#result-container");
			result_container.html(result.html);
			$(".jumbotron").fadeOut();
			$.jqplot("histogram",  [result.histogram],
				{ 
					axes:{xaxis:{min:0, max:256},yaxis:{min:0}}
				}
			);
		},
		error: function(error){
			var result_container = $("#result-container");
			result_container.html(error);
		}
	});
});',View::POS_END, 'my-options');

}

?>
<div class="site-index">
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
    
    <div class="body-content">
    	<?php if($model->file){ ?>
    	<div class="jumbotron">
        <h2>Please wait while your image is being processed..</h2>
        </div>
        <?php }?>
        <div id="result-container">

        </div>
    </div>
</div>
