<?php namespace app\models;

use Yii;
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