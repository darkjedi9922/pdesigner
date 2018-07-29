<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Project;
use app\models\Issue;
use app\models\AddProjectForm;

class ProjectController extends Controller
{
    public $layout = 'dashboard';

    /**
     * @param int $id id проекта
     * @return string
     */
    public function actionIndex($id)
    {
        $project = Project::findOne($id);
        if (!$project) {
            Yii::$app->response->statusCode = 404;
            return;
        }
        $issues = Issue::find()->where(['project_id' => $id])->orderBy('id ASC')->all();
        return $this->render('index', [
            'project' => $project,
            'issues' => $issues
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionAdd()
    {
        $model = new AddProjectForm();
        if ($model->load(Yii::$app->request->post()) && $project = $model->add()) {
            return $this->redirect(['project/index', 'id' => $project->id]);
        }

        return $this->render('add');
    }
}