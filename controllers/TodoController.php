<?php namespace app\controllers;

use Yii;
use yii\base\Controller;
use app\models\Issue;

class TodoController extends Controller
{
    public function actionToggle()
    {
        $post = Yii::$app->request->post();
        if (isset($post['id']) && isset($post['checked'])) {
            $issue = Issue::findOne(['id' => $post['id']]);
            if ($issue) {
                $issue->checked = $post['checked'];
                $issue->save();
            }
        }
    }
}