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
		$("#submit-pest").click(function(){
	        $("input[name=\'SearchForm[type]\'][value=\'pest\']").prop("checked",true);
	        $("#text-search-form").submit();
	    });
	    $("#submit-disease").click(function(){
	        $("input[name=\'SearchForm[type]\'][value=\'disease\']").prop("checked",true);
	        $("#text-search-form").submit();
	    });
	    $("#submit-pest-image").click(function(){
	        $("input[name=\'SearchForm[type]\'][value=\'pest\']").prop("checked",true);
	        $("#image-search-form").submit();
	    });
	    $("#submit-disease-image").click(function(){
	        $("input[name=\'SearchForm[type]\'][value=\'disease\']").prop("checked",true);
	        $("#image-search-form").submit();
	    });
	$(".wrap > .container").attr("style","padding:0px 15px 20px !important;");
});',View::POS_END, 'my-options');
if($model->file){
$this->registerCssFile(BaseUrl::base().'/css/jquery.jqplot.css');
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
		$("#submit-pest").click(function(){
	        $("input[name=\'SearchForm[type]\'][value=\'pest\']").prop("checked",true);
	        $("#text-search-form").submit();
	    });
	    $("#submit-disease").click(function(){
	        $("input[name=\'SearchForm[type]\'][value=\'disease\']").prop("checked",true);
	        $("#text-search-form").submit();
	    });
	    $("#submit-pest-image").click(function(){
	        $("input[name=\'SearchForm[type]\'][value=\'pest\']").prop("checked",true);
	        $("#image-search-form").submit();
	    });
	    $("#submit-disease-image").click(function(){
	        $("input[name=\'SearchForm[type]\'][value=\'disease\']").prop("checked",true);
	        $("#image-search-form").submit();
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
		<div class="row">
		<img src="<?php echo BaseUrl::base(); ?>/logo.png" class="col-md-2" width="300px" height="50px"/>
		<?php $form = ActiveForm::begin(['options' =>['id'=>'text-search-form','class'=>'form-inline']]); ?>
            <div class="form-group">
                <?= $form->field($model, 'search')->textInput(["style"=>"width:300px !important;"]) ?>
                <button id="show-image-form" type="button" class="btn btn-default btn-sm" style="padding: 5px 24px !important;">
                  <span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
                </button>

                <?= $form->field($model,'type')->radioList(["pest"=>"Pest","disease"=>"Disease"],['hidden'=>'hidden']); ?>
            </div>
            <?= Html::button('Pests', ['id'=>'submit-pest','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>

            <?= Html::button('Diseases', ['id'=>'submit-disease','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>
        <?php ActiveForm::end(); ?>

        <?php $form = ActiveForm::begin(['options' => ['hidden'=>'hidden','id'=>'image-search-form','class'=>'form-inline','enctype' => 'multipart/form-data'] ]);?>
                <?= $form->field($model, 'file')->fileInput(["style"=>"width:300px !important;","class"=>"form-control"]); ?>
                <button id="show-text-form" type="button" class="btn btn-default btn-sm" style="padding: 5px 24px !important;">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <?= $form->field($model,'type')->radioList(["pest"=>"Pest","disease"=>"Disease"],['hidden'=>'hidden']); ?>
                <?= Html::button('Pests', ['id'=>'submit-pest-image','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>

                <?= Html::button('Diseases', ['id'=>'submit-disease-image','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>
        <?php ActiveForm::end(); ?>
    	</div>
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
