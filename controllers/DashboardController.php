<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class DashboardController extends Controller
{
    public $layout = 'dashboard';

    public function actionIndex()
    {
        return $this->render('index');
    }
}