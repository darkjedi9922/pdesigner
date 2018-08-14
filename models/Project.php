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

    /**
     * @return ProjectDescription|null
     */
    public function loadDescription()
    {
        return ProjectDescription::find()->where(['project_id' => $this->id])->one();
    }

    /**
     * {@inheritDoc}
     */
    public function delete() 
    {
        ProjectDescription::deleteAll(['project_id' => $this->id]);
        return parent::delete();
    }
}