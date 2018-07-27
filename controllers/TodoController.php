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
            $data = ['checked' => $post['checked']];
            $condition = 'id = ' . $post['id'];
            Issue::updateAll($data, $condition);
        }
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        if ($id) {
            Issue::deleteAll('id = '.$id);
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