<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class DashboardController extends Controller
{
    public $layout = 'dashboard';

    /** {@inheritdoc} */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['site/login']);
                }
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}