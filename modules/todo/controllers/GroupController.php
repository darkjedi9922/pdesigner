<?php

namespace app\modules\todo\controllers;

use yii\web\Controller;
use app\modules\todo\models\IssueGroup;
use app\modules\todo\models\GroupRights;
use Yii;
use yii\web\NotFoundHttpException;
use app\modules\project\models\Project;

class GroupController extends Controller
{
    /** @var GroupRights $rights */
    public $rights;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->rights = new GroupRights(Yii::$app->user->identity);
    }

    /**
     * @param int $group Id of the group
     * @param int $color Id of the color
     */
    public function actionSetColor($group, $color)
    {
        $group = IssueGroup::findOne($group);
        if (!$group || !$this->rights->canSetColor($group))
            throw new NotFoundHttpException;
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
        if (!$group || !$this->rights->canSetName($group))
            throw new NotFoundHttpException;
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
        if (!$projectObject || !$this->rights->canAdd($projectObject))
            throw new NotFoundHttpException;

        $group = new IssueGroup();
        $group->name = 'Новая группа';
        $group->color_id = 4;
        $group->project_id = $project;
        $group->insert();
        echo json_encode([
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
        if (!$group || !$this->rights->canDelete($group))
            throw new NotFoundHttpException;
        $group->delete();
    }
}