<?php namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Issue;
use app\models\AddTaskForm;

class TodoController extends Controller
{
    public $layout = 'project';

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

    /**
     * @return Response|string
     */
    public function actionAddItem()
    {
        $model = new AddTaskForm();
        if ($model->load(Yii::$app->request->post()) && $model->add()) return $this->redirect(['project/index']);
        return $this->render('add-item');
    }
}