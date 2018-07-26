<?php namespace app\models;

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
}