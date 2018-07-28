<?php namespace app\models;

use yii\base\Model;
use yii\helpers\Html;
use app\models\Issue;

class EditTaskForm extends Model
{
    public $id;
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required']
        ];
    }

    /**
     * @return bool было ли добавлено задание
     */
    public function edit()
    {
        if ($this->validate()) {
            Issue::updateAll([
              'title' => $this->title  
            ], 'id = '.$this->id);
            return true;
        }
        return false;
    }
}