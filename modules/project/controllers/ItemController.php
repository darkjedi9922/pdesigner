<?php

namespace app\modules\project\controllers;

use Yii;
use yii\web\Controller;
use app\modules\project\models\Project;
use app\modules\todo\models\Issue;
use app\modules\project\models\AddProjectForm;
use app\modules\project\models\EditProjectForm;
use app\modules\todo\models\IssueGroup;
use app\modules\project\models\ProjectRights;
use yii\web\NotFoundHttpException;

class ItemController extends Controller
{
    public $layout = '@app/views/layouts/dashboard';

    /** @var ProjectRights $rights */
    public $rights;

    public function init()
    {
        parent::init();
        $this->rights = new ProjectRights(Yii::$app->user->identity);
    }

    /**
     * @param int $id id проекта
     * @return string
     */
    public function actionIndex($id)
    {
        $project = Project::findOne($id);
        if (!$project || !$this->rights->canSee($project)) 
            throw new NotFoundHttpException;

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
        if (!$this->rights->canAdd()) throw new NotFoundHttpException;

        $model = new AddProjectForm();
        if ($model->load(Yii::$app->request->post()) && $project = $model->add()) {
            return $this->redirect(['/project', 'id' => $project->id]);
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
        if (!$project || !$this->rights->canEdit($project)) 
            throw new NotFoundHttpException;

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
        if (!$project || !$this->rights->canDelete($project))
            throw new NotFoundHttpException;

        $project->delete();
        $this->redirect(['/dashboard']);
    }
}