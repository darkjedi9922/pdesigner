<?php namespace app\modules\todo\models;

use yii\db\ActiveRecord;
use app\modules\project\models\Project;
use yii\behaviors\TimestampBehavior;

class IssueGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_groups';
    }

    /** {@inheritdoc} */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class
            ]
        ];
    }

    /**
     * Removes the group and all of its tasks.
     * 
     * @param int $id Id of the group
     */
    public static function remove($id)
    {
        $tasks = Issue::find()->where(['group_id' => $id])->all();
        for ($i = 0, $c = count($tasks); $i < $c; ++$i) $tasks[$i]->delete();
        static::deleteAll('id = '. $id);
    }

    public function findProject(): Project
    {
        return Project::findOne($this->project_id);
    }
}