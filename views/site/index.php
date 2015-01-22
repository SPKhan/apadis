<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseUrl;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$this->title = 'Pest and Diseases Search Engine';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Pest and Diseases Search</h1>
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'search') ?>

                <div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                </div>

        <?php ActiveForm::end(); ?>

        <p><a class="btn btn-success" href="<?php echo Url::toRoute('site/imagesearch'); ?>">Try image search</a></p>
    </div>

    <div class="body-content">


    </div>
</div>
