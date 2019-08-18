<?php

namespace app\modules\todo\controllers;

use Yii;
use app\modules\todo\models\Issue;
use app\modules\todo\models\AddTaskForm;
use app\modules\todo\models\EditTaskForm;
use app\modules\todo\models\IssueText;
use app\modules\project\models\Project;
use app\modules\todo\models\IssueGroup;
use yii\web\NotFoundHttpException;

class ItemController extends \yii\web\Controller
{
    public $layout = '@app/views/layouts/dashboard';

    public function actionToggle()
    {
        $post = Yii::$app->request->post();
        if (!isset($post['id']) || !isset($post['status'])) 
            throw new NotFoundHttpException;
        
        $issue = Issue::findOne($post['id']);
        if (!Yii::$app->user->can('toggleIssue', ['issue' => $issue]))
            throw new NotFoundHttpException;

        $issue->status = $post['status'];
        $issue->save();
    }

    /**
     * @param int $id Id задачи
     */
    public function actionDelete($id)
    {
        $issue = Issue::findOne($id);
        if (!Yii::$app->user->can('deleteIssue', ['issue' => $issue])) 
            throw new NotFoundHttpException;

        $issue->delete();

        // Редирект если не ajax
        if (!Yii::$app->request->isAjax && $issue->project_id !== null)
            $this->redirect(['/project', 'id' => $issue->project_id]);
    }

    /**
     * Нужно передать либо parent, либо gid
     * 
     * @param int $parent id родительской задачи
     * @param int $group id группы задач
     * @return Response|string
     */
    public function actionAdd($parent = null, $group = null)
    {
        if ($parent) {
            $parent = Issue::findOne($parent);
            if (!$parent) throw new NotFoundHttpException;
            $group = IssueGroup::findOne($parent->group_id);
        } else if ($group) {
            $group = IssueGroup::findOne($group);
        }

        $project = Project::findOne($group->project_id);
        if (!Yii::$app->user->can('addIssue', ['project' => $project]))
            throw new NotFoundHttpException;

        $model = new AddTaskForm();
        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            return $this->redirect(['/todo', 'id' => $model->getAddedIssue()->id]);
        }

        return $this->render('add', [
            'parent' => $parent,
            'group' => $group,
            'project' => $project
        ]);
    }

    /**
     * @param int $id
     * @return Response|string
     */
    public function actionEdit($id)
    {
        $item = Issue::findOne($id);
        if (!Yii::$app->user->can('editIssue', ['issue' => $item]))
            throw new NotFoundHttpException;

        $text = IssueText::find()->where(['issue_id' => $id])->one();
        $text = ($text && $text->text) ? $text->text : '';
        $project = Project::findOne($item->project_id);

        if (Yii::$app->request->isPost) {
            $model = new EditTaskForm();
            $model->id = $id;
            if ($model->load(Yii::$app->request->post()) && $model->edit()) {
                return $this->redirect(['/todo', 'id' => $model->id]);
            }
        } else {
            return $this->render('edit', [
                'item' => $item,
                'text' => $text,
                'project' => $project
            ]);
        }
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionIndex($id)
    {
        // Загружаем саму задачу
        $issue = Issue::findOne($id);
        if (!Yii::$app->user->can('viewIssue', ['issue' => $issue]))
            throw new NotFoundHttpException;

        // Находим ее родителя
        if ($issue->parent_issue_id) $parent = Issue::find()->where(['id' => $issue->parent_issue_id])->one();
        else $parent = null;
        // Находим ее текст
        $text = IssueText::find()->where(['issue_id' => $id])->one();
        $text = ($text && $text->text) ? $text->text : '';
        // Проект
        $project = Project::findOne($issue->project_id);
        // Рендерим
        return $this->render('index', [
            'issue' => $issue,
            'parent' => $parent,
            'text' => $text,
            'project' => $project
        ]);
    }
}