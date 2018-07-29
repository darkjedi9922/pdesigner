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
}