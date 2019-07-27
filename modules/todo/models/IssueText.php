<?php namespace app\modules\todo\models;

use yii\db\ActiveRecord;

class IssueText extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_texts';
    }
}