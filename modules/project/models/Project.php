<?php namespace app\modules\project\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Project extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }

    /** {@inheritdoc} */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    // EVENT_BEFORE_UPDATE делаем вручную.
                    // Подробнее см. в EditProjectForm.
                ],
            ]
        ];
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