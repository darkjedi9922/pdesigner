<?php namespace app\modules\project\models;

use yii\base\Model;
use yii\helpers\Html;
use app\modules\project\models\Project;
use app\modules\project\models\ProjectDescription;

class EditProjectForm extends Model
{
    public $id;
    public $name;
    public $description = null;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['description', 'string']
        ];
    }

    /**
     * @return bool было ли добавлено задание
     */
    public function edit()
    {
        if ($this->validate()) {
            // Обновляем основную часть
            Project::updateAll([
                'name' => Html::encode($this->name)
            ], 'id = ' . $this->id);
            // Обновляем описание или добавляем, если его не было
            // Или удаляем если его стерли
            if ($this->description !== null) {
                if (!$this->description) ProjectDescription::deleteAll(['project_id' => $this->id]);
                else {
                    $desc = ProjectDescription::find()->where(['project_id' => $this->id])->one();
                    if ($desc) {
                        if ($desc->description !== $this->description) {
                            $desc->description = Html::encode($this->description);
                            $desc->save();
                        }
                    } else {
                        $desc = new ProjectDescription();
                        $desc->project_id = $this->id;
                        $desc->description = $this->description;
                        $desc->insert();
                    }
                }
            }
            return true;
        }
        return false;
    }
}