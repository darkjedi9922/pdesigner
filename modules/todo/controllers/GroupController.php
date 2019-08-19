<?php

namespace app\modules\todo\controllers;

use yii\web\Controller;
use app\modules\todo\models\IssueGroup;
use Yii;
use yii\web\NotFoundHttpException;
use app\modules\project\models\Project;

class GroupController extends Controller
{
    /**
     * @param int $group Id of the group
     * @param int $color Id of the color
     */
    public function actionSetColor($group, $color)
    {
        $group = IssueGroup::findOne($group);
        if (!Yii::$app->user->can('setIssueGroupColor', [
            'project' => $group ? $group->findProject() : null
        ])) {
            throw new NotFoundHttpException;
        }
        $group->color_id = $color;
        $group->save();
    }

    /**
     * @param int $group Id of the group
     * @param int $name New name
     */
    public function actionSetName($group, $name)
    {
        $group = IssueGroup::findOne($group);
        if (!Yii::$app->user->can('setIssueGroupName', [
            'project' => $group ? $group->findProject() : null
        ])) {
            throw new NotFoundHttpException;
        }
        $group->name = $name;
        $group->save();
    }

    /**
     * @param int $project Id of the project
     * @return string Id новой группы
     */
    public function actionAdd($project)
    {
        $projectObject = Project::findOne($project);
        if (!Yii::$app->user->can('addIssueGroup', ['project' => $projectObject]))
            throw new NotFoundHttpException;

        $group = new IssueGroup();
        $group->name = 'Новая группа';
        $group->color_id = 4;
        $group->project_id = $project;
        $group->insert();
        return json_encode([
            'id' => $group->id,
            'name' => $group->name,
            'color_id' => $group->color_id
        ]);
    }

    /**
     * @param int $group Id of the group
     */
    public function actionDelete($group)
    {
        $group = IssueGroup::findOne($group);
        if (!Yii::$app->user->can('deleteIssueGroup', [
            'project' => $group ? $group->findProject() : null
        ])) {
            throw new NotFoundHttpException;
        }
        $group->delete();
    }
}