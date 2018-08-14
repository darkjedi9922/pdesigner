<?php namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ProjectDescription extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_descriptions';
    }
}