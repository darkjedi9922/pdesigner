<?php namespace app\modules\todo\models;

use yii\base\Model;
use yii\helpers\Html;
use app\modules\todo\models\Issue;
use app\modules\todo\models\IssueText;

class EditTaskForm extends Model
{
    public $id;
    public $title;
    public $text = null;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            ['text', 'string']
        ];
    }

    /**
     * @return bool было ли добавлено задание
     */
    public function edit()
    {
        if ($this->validate()) {
            // Обновляем основную часть
            Issue::updateAll([
              'title' => Html::encode($this->title)
            ], 'id = '.$this->id);
            // Обновляем текст или добавляем, если его не было
            if ($this->text !== null) {
                if (!$this->text) IssueText::deleteAll(['issue_id' => $this->id]);
                else {
                    $text = IssueText::find()->where(['issue_id' => $this->id])->one();
                    if ($text) {
                        if ($text->text !== $this->text) {
                            $text->text = Html::encode($this->text);
                            $text->save();
                        }
                    } else {
                        $text = new IssueText();
                        $text->issue_id = $this->id;
                        $text->text = $this->text;
                        $text->insert();
                    }
                }
            }
            return true;
        }
        return false;
    }
}