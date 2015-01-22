<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = 'Pest and Diseases Image Search';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Pest and Diseases Image Search</h1>

         <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'] ]);?>
	    		<?= $form->field($model, 'file')->fileInput(); ?>
	 			<?= $form->field($model,'type')->radioList(["pest"=>"Pest","disease"=>"Disease"]); ?>

	    		<div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                </div>

        <?php ActiveForm::end(); ?>
        
            
        <p><a class="btn btn-success" href="<?php echo Url::toRoute('site/index'); ?>">Back to Text Search</a></p>
    </div>

    <div class="body-content">


    </div>
</div>