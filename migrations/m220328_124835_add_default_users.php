<?php

use yii\db\Migration;

/**
 * Class m220328_124835_add_default_users
 */
class m220328_124835_add_default_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220328_124835_add_default_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220328_124835_add_default_users cannot be reverted.\n";

        return false;
    }
    */
}
