<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ProjectController extends Controller
{
    public $layout = 'project';

    public function actionIndex()
    {
        return $this->render('index');
    }
}