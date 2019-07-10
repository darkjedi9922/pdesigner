<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class DashboardController extends Controller
{
    public $layout = 'dashboard';

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) $this->redirect(['site/login']);
        return $this->render('index');
    }
}