<?php

namespace app\modules\project\controllers;

use Yii;
use yii\web\Controller;
use app\modules\project\models\Project;
use app\modules\todo\models\Issue;
use app\modules\project\models\AddProjectForm;
use app\modules\project\models\EditProjectForm;
use app\modules\todo\models\IssueGroup;

class ItemController extends Controller
{
    public $layout = '@app/views/layouts/dashboard';

    /**
     * @param int $id id проекта
     * @return string
     */
    public function actionIndex($id)
    {
        $project = Project::findOne([
            'id' => $id,
            'author_id' => Yii::$app->user->id
        ]);
        if (!$project) return Yii::$app->response->statusCode = 404;

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
            return $this->redirect(['index', 'id' => $project->id]);
        }

        return $this->render('add');
    }

    /**
     * @param int $id Id проекта
     * @return Response|string
     */
    public function actionEdit($id)
    {
        $project = Project::findOne([
            'id' => $id,
            'author_id' => Yii::$app->user->id
        ]);
        if (!$project) return Yii::$app->response->statusCode = 404;

        if (Yii::$app->request->isPost) {
            $form = new EditProjectForm();
            $form->id = $id;
            if ($form->load(Yii::$app->request->post()) && $form->edit()) {
                return $this->redirect(['index', 'id' => $id]);
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
        $project = Project::findOne([
            'id' => $id,
            'author_id' => Yii::$app->user->id
        ]);
        if ($project) $project->delete();
        $this->redirect(['/dashboard']);
    }
}