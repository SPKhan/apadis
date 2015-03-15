<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\widgets\ActiveForm;
use yii\web\View;
/* @var $this yii\web\View */
$this->title = 'Pest and Diseases Search Results';
$this->registerJs('$(".wrap > .container").attr("style","padding:0px 15px 20px !important;");',View::POS_END, 'my-options');
$this->registerJsFile(BaseUrl::base().'/js/main.js',['depends' => [yii\web\JqueryAsset::className()]]);
if($model->file){
$this->registerCssFile(BaseUrl::base().'/css/jquery.jqplot.css');
$this->registerJsFile(BaseUrl::base().'/js/jquery.jqplot.min.js',['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJs('
	$("document").ready(function() {
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
		<?php $form = ActiveForm::begin(['options' =>['id'=>'text-search-form','class'=>'form-inline']]); ?>
            <div class="form-group">
                <?= $form->field($model, 'search')->textInput(["style"=>"width:700px !important;"]) ?>
                <button id="show-image-form" type="button" class="btn btn-default btn-sm" style="padding: 5px 24px !important;">
                  <span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
                </button>

                <?= $form->field($model,'type')->radioList(["pest"=>"Pest","disease"=>"Disease"],['hidden'=>'hidden']); ?>
            </div>
            <?= Html::button('Pests', ['id'=>'submit-pest','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>

            <?= Html::button('Diseases', ['id'=>'submit-disease','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>
        <?php ActiveForm::end(); ?>

        <?php $form = ActiveForm::begin(['options' => ['hidden'=>'hidden','id'=>'image-search-form','class'=>'form-inline','enctype' => 'multipart/form-data'] ]);?>
                <div class='input-container row' style="width:700px;margin-left:10px;">

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
                <div style="margin-left:10px;">
                <?= Html::button('Pests', ['id'=>'submit-pest-image','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>

                <?= Html::button('Diseases', ['id'=>'submit-disease-image','class' => 'btn btn-sm btn-default','style'=>'padding: 5px 24px !important;']) ?>
            	</div>
        <?php ActiveForm::end(); ?>
    	</div>
    <br/>
    <img id="preview" src="" />
    <br/><br/>
    <div class="body-content">
    	<?php if($model->file){ ?>
    	<div class="jumbotron">
        <h2>Please wait while your image is being processed..</h2>
        </div>
        <?php }?>
        <div id="result-container">
        <?php if(!$model->file){ ?>
    		<div class="btn-group" role="group" aria-label="...">
	                <button type="button" class="th-btn btn btn-primary">
	                    <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
	                </button>
	                <button type="button" class="list-btn btn btn-default">
	                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
	                </button>
	        </div>
	    	
	        <br/>
	        <br/>
	        <div class="thumbnail-format row">


	          <div class="col-xs-6 col-md-4">
	            <div class="thumbnail entry entry-1">
	              <img src="uploads/1672.png" />
	            </div>
	            <div class="caption caption-1">
	                <h3>Lorem Ipsum</h3>
	                <p>Scientific Name: Lorem Ipsum</p>
	                <p>Filipino Name: Lorem Ipsum</p>
	                <button type="button" class="btn btn-primary">
	                    Read More
	                </button>
	                <button type="button" class="btn btn-default caption-close-btn">
	                    Close
	                </button>
	            </div>
	          </div>
	          <div class="col-xs-6 col-md-4">
	            <div href="#" class="thumbnail entry entry-2">
	              <img src="uploads/6521.png" />
	            </div>
	            <div class="caption caption-2">
	                <h3>Lorem Ipsum</h3>
	                <p>Scientific Name: Lorem Ipsum</p>
	                <p>Filipino Name: Lorem Ipsum</p>
	                <button type="button" class="btn btn-primary">
	                    Read More
	                </button>
	                <button type="button" class="btn btn-default caption-close-btn">
	                    Close
	                </button>
	            </div>
	          </div>
	          <div class="col-xs-6 col-md-4">
	            <div href="#" class="thumbnail entry entry-3">
	              <img src="uploads/8572.jpg" />
	            </div>
	            <div class="caption caption-3">
	                <h3>Lorem Ipsum</h3>
	                <p>Scientific Name: Lorem Ipsum</p>
	                <p>Filipino Name: Lorem Ipsum</p>
	                <button type="button" class="btn btn-primary">
	                    Read More
	                </button>
	                <button type="button" class="btn btn-default caption-close-btn">
	                    Close
	                </button>
	            </div>
	          </div>

	          <div class="col-xs-6 col-md-4">
	            <div href="#" class="thumbnail entry entry-4">
	              <img src="uploads/1672.png" />
	            </div>
	            <div class="caption caption-4">
	                <h3>Lorem Ipsum</h3>
	                <p>Scientific Name: Lorem Ipsum</p>
	                <p>Filipino Name: Lorem Ipsum</p>
	                <button type="button" class="btn btn-primary">
	                    Read More
	                </button>
	                <button type="button" class="btn btn-default caption-close-btn">
	                    Close
	                </button>
	            </div>
	          </div>
	          <div class="col-xs-6 col-md-4">
	            <div href="#" class="thumbnail entry entry-5">
	              <img src="uploads/1672.png" />
	            </div>
	            <div class="caption caption-5">
	                <h3>Lorem Ipsum</h3>
	                <p>Scientific Name: Lorem Ipsum</p>
	                <p>Filipino Name: Lorem Ipsum</p>
	                <button type="button" class="btn btn-primary">
	                    Read More
	                </button>
	                <button type="button" class="btn btn-default caption-close-btn">
	                    Close
	                </button>
	            </div>
	          </div>
	          <div class="col-xs-6 col-md-4">
	            <div href="#" class="thumbnail entry entry-6">
	              <img src="uploads/1672.png" />
	            </div>
	            <div class="caption caption-6">
	                <h3>Lorem Ipsum</h3>
	                <p>Scientific Name: Lorem Ipsum</p>
	                <p>Filipino Name: Lorem Ipsum</p>
	                <button type="button" class="btn btn-primary">
	                    Read More
	                </button>
	                <button type="button" class="btn btn-default caption-close-btn">
	                    Close
	                </button>
	            </div>
	          </div>



	        </div>


	        <div class='list-format'>
	            <div class="media">
	              <div class="media-left media-middle">
	                <a href="#">
	                  <img class='media-object' src="uploads/1672.png" />
	                </a>
	              </div>
	              <div class="media-body">
	                <a><h4 class="media-heading">Lorem Ipsum</h4></a>
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla accumsan lectus quis condimentum molestie. Aliquam vel orci ac orci tristique fringilla. Aliquam nec venenatis arcu, nec vulputate arcu. Nulla facilisi. Morbi eget quam vitae augue ornare porttitor. Curabitur pretium nibh sed mi ornare faucibus. Nunc eros ipsum, laoreet sed dui et, rhoncus dictum erat. Quisque blandit leo vel ligula suscipit aliquet in eu nibh. In sit amet sapien odio. Duis a elit id velit rutrum suscipit et et turpis. Mauris sagittis malesuada ex, ac aliquet dolor porttitor et. Vestibulum sit amet eros maximus, posuere lacus nec, posuere lectus. Mauris nec nunc eu lacus efficitur suscipit vitae non nulla. Cras a diam felis. 
	              </div>
	            </div>

	            <hr/>

	            <div class="media">
	              <div class="media-left media-middle">
	                <a href="#">
	                  <img class='media-object' src="uploads/1672.png" />
	                </a>
	              </div>
	              <div class="media-body">
	                <a><h4 class="media-heading">Lorem Ipsum</h4></a>
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla accumsan lectus quis condimentum molestie. Aliquam vel orci ac orci tristique fringilla. Aliquam nec venenatis arcu, nec vulputate arcu. Nulla facilisi. Morbi eget quam vitae augue ornare porttitor. Curabitur pretium nibh sed mi ornare faucibus. Nunc eros ipsum, laoreet sed dui et, rhoncus dictum erat. Quisque blandit leo vel ligula suscipit aliquet in eu nibh. In sit amet sapien odio. Duis a elit id velit rutrum suscipit et et turpis. Mauris sagittis malesuada ex, ac aliquet dolor porttitor et. Vestibulum sit amet eros maximus, posuere lacus nec, posuere lectus. Mauris nec nunc eu lacus efficitur suscipit vitae non nulla. Cras a diam felis. 
	              </div>
	            </div>

	            <hr/>

	            <div class="media">
	              <div class="media-left media-middle">
	                <a href="#">
	                  <img class='media-object' src="uploads/1672.png" />
	                </a>
	              </div>
	              <div class="media-body">
	                <a><h4 class="media-heading">Lorem Ipsum</h4></a>
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla accumsan lectus quis condimentum molestie. Aliquam vel orci ac orci tristique fringilla. Aliquam nec venenatis arcu, nec vulputate arcu. Nulla facilisi. Morbi eget quam vitae augue ornare porttitor. Curabitur pretium nibh sed mi ornare faucibus. Nunc eros ipsum, laoreet sed dui et, rhoncus dictum erat. Quisque blandit leo vel ligula suscipit aliquet in eu nibh. In sit amet sapien odio. Duis a elit id velit rutrum suscipit et et turpis. Mauris sagittis malesuada ex, ac aliquet dolor porttitor et. Vestibulum sit amet eros maximus, posuere lacus nec, posuere lectus. Mauris nec nunc eu lacus efficitur suscipit vitae non nulla. Cras a diam felis. 
	              </div>
	            </div>

	            <hr/>

	            <div class="media">
	              <div class="media-left media-middle">
	                <a href="#">
	                  <img class='media-object' src="uploads/1672.png" />
	                </a>
	              </div>
	              <div class="media-body">
	                <a><h4 class="media-heading">Lorem Ipsum</h4></a>
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla accumsan lectus quis condimentum molestie. Aliquam vel orci ac orci tristique fringilla. Aliquam nec venenatis arcu, nec vulputate arcu. Nulla facilisi. Morbi eget quam vitae augue ornare porttitor. Curabitur pretium nibh sed mi ornare faucibus. Nunc eros ipsum, laoreet sed dui et, rhoncus dictum erat. Quisque blandit leo vel ligula suscipit aliquet in eu nibh. In sit amet sapien odio. Duis a elit id velit rutrum suscipit et et turpis. Mauris sagittis malesuada ex, ac aliquet dolor porttitor et. Vestibulum sit amet eros maximus, posuere lacus nec, posuere lectus. Mauris nec nunc eu lacus efficitur suscipit vitae non nulla. Cras a diam felis. 
	              </div>
	            </div>

	            <hr/>

	            <div class="media">
	              <div class="media-left media-middle">
	                <a href="#">
	                  <img class='media-object' src="uploads/1672.png" />
	                </a>
	              </div>
	              <div class="media-body">
	                <a><h4 class="media-heading">Lorem Ipsum</h4></a>
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla accumsan lectus quis condimentum molestie. Aliquam vel orci ac orci tristique fringilla. Aliquam nec venenatis arcu, nec vulputate arcu. Nulla facilisi. Morbi eget quam vitae augue ornare porttitor. Curabitur pretium nibh sed mi ornare faucibus. Nunc eros ipsum, laoreet sed dui et, rhoncus dictum erat. Quisque blandit leo vel ligula suscipit aliquet in eu nibh. In sit amet sapien odio. Duis a elit id velit rutrum suscipit et et turpis. Mauris sagittis malesuada ex, ac aliquet dolor porttitor et. Vestibulum sit amet eros maximus, posuere lacus nec, posuere lectus. Mauris nec nunc eu lacus efficitur suscipit vitae non nulla. Cras a diam felis. 
	              </div>
	            </div>

	            <hr/>

	            <div class="media">
	              <div class="media-left media-middle">
	                <a href="#">
	                  <img class='media-object' src="uploads/1672.png" />
	                </a>
	              </div>
	              <div class="media-body">
	                <a><h4 class="media-heading">Lorem Ipsum</h4></a>
	                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla accumsan lectus quis condimentum molestie. Aliquam vel orci ac orci tristique fringilla. Aliquam nec venenatis arcu, nec vulputate arcu. Nulla facilisi. Morbi eget quam vitae augue ornare porttitor. Curabitur pretium nibh sed mi ornare faucibus. Nunc eros ipsum, laoreet sed dui et, rhoncus dictum erat. Quisque blandit leo vel ligula suscipit aliquet in eu nibh. In sit amet sapien odio. Duis a elit id velit rutrum suscipit et et turpis. Mauris sagittis malesuada ex, ac aliquet dolor porttitor et. Vestibulum sit amet eros maximus, posuere lacus nec, posuere lectus. Mauris nec nunc eu lacus efficitur suscipit vitae non nulla. Cras a diam felis. 
	              </div>
	            </div>

	            <hr/>
	            
	        </div>
        <?php }?>
        </div>
    </div>
</div>
