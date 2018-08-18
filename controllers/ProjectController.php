<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Project;
use app\models\Issue;
use app\models\AddProjectForm;
use app\models\ProjectDescription;
use app\models\EditProjectForm;
use app\models\IssueGroup;

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
        $groups = IssueGroup::find()->where(['project_id' => $id])->orderBy('id ASC')->all();
        
        return $this->render('index', [
            'project' => $project,
            'desc' => $project->loadDescription(),
            'issues' => $issues,
            'groups' => $groups
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

    /**
     * @param int $id Id проекта
     * @return Response|string
     */
    public function actionEdit($id)
    {
        $project = Project::findOne($id);
        if (!$project) {
            Yii::$app->response->statusCode = 404;
            return;
        }

        if (Yii::$app->request->isPost) {
            $form = new EditProjectForm();
            $form->id = $id;
            if ($form->load(Yii::$app->request->post()) && $form->edit()) {
                return $this->redirect(['/project', 'id' => $id]);
            }
        }

        return $this->render('edit', [
            'project' => $project,
            'desc' => $project->loadDescription()
        ]);
    }

    /**
     * @param int $id Id проекта
     * @return Response
     */
    public function actionDelete($id)
    {
        $project = Project::findOne($id);
        if ($project) $project->delete();
        $this->redirect(['/dashboard']);
    }
}