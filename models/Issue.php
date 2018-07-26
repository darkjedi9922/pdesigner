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

    public static function calcNewNumber()
    {
        return Yii::$app->db->createCommand('SELECT MAX(number) FROM '.self::tableName())->queryScalar() + 1;
    }
}