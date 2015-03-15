<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SearchForm;
use app\models\ImagesearchForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new SearchForm();

        if (Yii::$app->request->isPost) {
                $model->file = UploadedFile::getInstance($model, 'file');
                $post;
                $this->layout='results';
                //if ($model->file && $model->validate()) {
                    if(!$model->file){
                        $query = $_POST['SearchForm']['search'];
                        $connection = new \yii\db\Connection([
                            'dsn' => 'mysql:host=127.0.0.1;dbname=spsarai',
                            'username' => 'root',
                            'password' => '',
                        ]);
                        $connection->open();

                        $command = $connection->createCommand('SELECT * FROM com_name WHERE com_name like "%Lorem%"');
                        $command->bindValue(':id', $_POST['SearchForm']['search']);
                        $post = $command->queryAll();

                        $connection->close();
                    }
                    else{
                        $random = rand(0,9999);
                        $model->filepath = 'uploads/' . $random . '.' . $model->file->extension;
                        $model->file->saveAs($model->filepath);
                    }

                    $model->type = $_POST['SearchForm']['type'];

                    return $this->render('searchresults',['model' => $model,'result' => $post]);
                //} 
        }

        return $this->render('index',['model' => $model]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

}
