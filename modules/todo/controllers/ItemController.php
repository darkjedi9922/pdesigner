<?php

namespace app\modules\todo\controllers;

use Yii;
use app\models\Issue;
use app\models\AddTaskForm;
use app\models\EditTaskForm;
use app\models\IssueText;
use app\models\Project;
use app\models\IssueGroup;

class ItemController extends \yii\web\Controller
{
    public $layout = '@app/views/layouts/dashboard';

    public function actionToggle()
    {
        $post = Yii::$app->request->post();
        if (isset($post['id']) && isset($post['status'])) {
            $issue = Issue::findMyOne($post['id']);
            $issue->status = $post['status'];
            $issue->save();
        }
    }

    /**
     * @param int $id Id задачи
     */
    public function actionDelete($id)
    {
        $issue = Issue::findMyOne($id);
        if (!$issue) return $this->goHome();

        $issue->delete();

        // Редирект если не ajax
        if (!Yii::$app->request->isAjax && $issue->project_id !== null)
            $this->redirect(['/project', 'id' => $issue->project_id]);
    }

    /**
     * Нужно передать либо parent, либо gid
     * 
     * @param int $parent id родительской задачи=
     * @param int $group id группы задач
     * @return Response|string
     */
    public function actionAdd($parent = null, $group = null)
    {
        if ($parent) {
            $parent = Issue::findOne($parent);
            $group = IssueGroup::findOne($parent->group_id);
        } else if ($group) {
            $group = IssueGroup::findOne($group);
        } else {
            Yii::$app->response->statusCode = 404;
            return;
        }

        $model = new AddTaskForm();
        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            return $this->redirect(['index', 'id' => $model->getAddedIssue()->id]);
        }

        $project = Project::findOne($group->project_id);
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
        $item = Issue::findMyOne($id);
        if ($item) {
            $text = IssueText::find()->where(['issue_id' => $id])->one();
            $text = ($text && $text->text) ? $text->text : '';
            $project = Project::findOne($item->project_id);
        } else return $this->goHome();

        if (Yii::$app->request->isPost) {
            $model = new EditTaskForm();
            $model->id = $id;
            if ($model->load(Yii::$app->request->post()) && $model->edit()) {
                return $this->redirect(['index', 'id' => $model->id]);
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
        $issue = Issue::findMyOne($id);
        if (!$issue) return $this->goHome();
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