<?php

use yii\db\Migration;

/**
 * Class m180716_084520_init_app
 */
class m180716_084520_init_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(127)->notNull()->unique(),
            'login_token' => $this->string(32)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'email' => $this->string(127)->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'balance' => $this->double()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

}
