<?php namespace app\modules\project\models;

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