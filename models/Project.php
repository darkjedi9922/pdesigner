<?php namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Project extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }
}