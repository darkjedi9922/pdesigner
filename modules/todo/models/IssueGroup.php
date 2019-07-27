<?php namespace app\modules\todo\models;

use yii\db\ActiveRecord;

class IssueGroup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_groups';
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
}