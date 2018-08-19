<?php namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Issue extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issues';
    }

    /**
     * @param int $projectId
     */
    public static function calcNewNumber($projectId)
    {
        return Yii::$app->db->createCommand(
            'SELECT MAX(number) FROM '.self::tableName().' WHERE project_id = '.$projectId
        )->queryScalar() + 1;
    }

    /**
     * Removes the issue and its text. 
     * The children is not removed.
     * 
     * @param int $id Id of the issue
     */
    public static function remove($id)
    {
        IssueText::deleteAll('issue_id = ' . $id);
        static::deleteAll('id = ' . $id);
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        IssueText::deleteAll('issue_id = ' . $this->id);
        parent::delete();
    }
}