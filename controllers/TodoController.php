<?php namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Issue;
use app\models\AddTaskForm;
use app\models\EditTaskForm;

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
     * @param int $parent id родительской задачи
     * @return Response|string
     */
    public function actionAddItem($parent = null)
    {
        $model = new AddTaskForm();
        if ($model->load(Yii::$app->request->post()) && $model->add()) return $this->redirect(['project/index']);
        return $this->render('add-item', [
            'parent' => $parent
        ]);
    }

    public function actionEditItem($id)
    {
        if (Yii::$app->request->isPost) {
            $model = new EditTaskForm();
            $model->id = $id;
            if ($model->load(Yii::$app->request->post()) && $model->edit()) return $this->redirect(['project/index']);
        } else {
            $item = Issue::find()->where(['id' => $id])->one();
            if ($item) return $this->render('edit-item', ['item' => $item]);
            else Yii::$app->response->statusCode = 404;
        }
    }
}