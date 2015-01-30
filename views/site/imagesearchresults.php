<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\web\View;
/* @var $this yii\web\View */
$this->title = 'Pest and Diseases Image Search Results';
$this->registerJs('
	$("document").ready(function() {
	$.ajax({
		type:"POST",
		url:"http://127.0.0.1:5000/imageSearch",
		data: 
			{
				filename:"../web/'.$model->filepath.'",
				type: "'.$model->type.'"
			},
		success: function(result){
			var result_container = $("#result-container");
			result_container.html(result);
			$(".jumbotron").fadeOut();
		},
		error: function(error){
			var result_container = $("#result-container");
			result_container.html(error);
		}
	});
});',View::POS_END, 'my-options');
?>
<div class="site-index">

    
    <div class="body-content">
    	<div class="jumbotron">
        <h2>Please wait while your image is being processed..</h2>
        </div>
        <div id="result-container">

        </div>
    </div>
</div>
