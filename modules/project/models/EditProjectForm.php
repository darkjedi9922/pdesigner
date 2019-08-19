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
            // Обновляем основную часть.
            // Можно было бы через updateAll(), чтобы не грузить весь проект, но
            // чтобы сработало поведение TimestampBehaviour нужен объект
            // определенного объекта, который нужно сохранить через save().
            $project = Project::findOne($this->id);
            $project->name = Html::encode($this->name);
            $project->save();

            // updated_at обновляется, если данные о проекте действительно меняются.
            // Но если мы не меняем данные о самом проекте, а меняем его описание,
            // все равно нужно обновить метку. Поэтому делаем это насильно вручную.
            $project->touch('updated_at');

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
                        $desc->description = Html::encode($this->description);
                        $desc->insert();
                    }
                }
            }
            return true;
        }
        return false;
    }
}