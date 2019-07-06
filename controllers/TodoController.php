<?php namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Issue;
use app\models\AddTaskForm;
use app\models\EditTaskForm;
use app\models\IssueText;
use app\models\Project;
use app\models\IssueGroup;

class TodoController extends Controller
{
    public $layout = 'dashboard';

    public function actionToggle()
    {
        $post = Yii::$app->request->post();
        if (isset($post['id']) && isset($post['status'])) {
            $data = ['status' => $post['status']];
            $condition = 'id = ' . $post['id'];
            Issue::updateAll($data, $condition);
        }
    }

    /**
     * @param int $id Id задачи
     */
    public function actionDelete($id)
    {
        // Нужно найти id проекта этой задачи для редиректа, если это не ajax
        if (!Yii::$app->request->isAjax) {
            $issue = Issue::find()->where(['id' => $id])->one();
            if ($issue) $projectId = $issue->project_id;
            else $projectId = null;
        }

        Issue::remove($id);

        // Редирект если не ajax
        if (!Yii::$app->request->isAjax && $projectId !== null) $this->redirect(['project/index', 'id' => $projectId]);
    }

    /**
     * Нужно передать либо parent, либо gid
     * 
     * @param int $parent id родительской задачи=
     * @param int $group id группы задач
     * @return Response|string
     */
    public function actionAddItem($parent = null, $group = null)
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
            return $this->redirect(['todo/index', 'id' => $model->getAddedIssue()->id]);
        }

        $project = Project::findOne($group->project_id);
        return $this->render('add-item', [
            'parent' => $parent,
            'group' => $group,
            'project' => $project
        ]);
    }

    /**
     * @param int $id
     * @return Response|string
     */
    public function actionEditItem($id)
    {
        $item = Issue::find()->where(['id' => $id])->one();
        if ($item) {
            $text = IssueText::find()->where(['issue_id' => $id])->one();
            $text = ($text && $text->text) ? $text->text : '';
            $project = Project::findOne($item->project_id);
        } else {
            Yii::$app->response->statusCode = 400;
            return;
        }

        if (Yii::$app->request->isPost) {
            $model = new EditTaskForm();
            $model->id = $id;
            if ($model->load(Yii::$app->request->post()) && $model->edit()) {
                return $this->redirect(['todo/index', 'id' => $model->id]);
            }
        } else {
            return $this->render('edit-item', [
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
        $issue = Issue::find()->where(['id' => $id])->one();
        if (!$issue) {
            Yii::$app->response->statusCode = 404;
            return;
        }
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