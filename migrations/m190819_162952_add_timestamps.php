<?php

use yii\db\Migration;

/**
 * Class m190819_162952_add_timestamps
 */
class m190819_162952_add_timestamps extends Migration
{
    private $tables = [
        'users',
        'projects',
        'issue_groups',
        'issues'
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->tables as $table) $this->addTimestampColumns($table);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->tables as $table) $this->removeTimestampColumns($table);
    }

    private function addTimestampColumns(string $table)
    {
        $this->addColumn($table, 'created_at', $this->integer(11)->notNull());
        $this->addColumn($table, 'updated_at', $this->integer(11)->notNull());
        
        $value = time();
        $this->update($table, [
            'created_at' => $value,
            'updated_at' => $value
        ]);
    }

    private function removeTimestampColumns(string $table)
    {
        $this->dropColumn($table, 'created_at');
        $this->dropColumn($table, 'updated_at');
    }
}