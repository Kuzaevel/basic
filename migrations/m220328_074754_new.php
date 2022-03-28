<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m220328_074754_new
 */
class m220328_074754_new extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();

        try {

            $this->execute('CREATE OR REPLACE FUNCTION public.gen_random_uuid()
                                     RETURNS uuid
                                     LANGUAGE c
                                     PARALLEL SAFE
                                    AS \'$libdir/pgcrypto\', $function$pg_random_uuid$function$
                                    ;');

            $this->createTable('{{%users}}', [
                'primarykey' => 'uuid NOT NULL DEFAULT gen_random_uuid()',
                'username'   => $this->string(255)->notNull(),
                'email'      => $this->string(255)->notNull(),
                'type'       => $this->string(50)->notNull()->defaultValue('client'),
                'role'       => $this->integer(4)->notNull()->defaultValue(10),
                'active'     => $this->boolean()->notNull()->defaultValue(true),
                'created_at' => $this->timestamp(0)->notNull()->defaultExpression('NOW()'),
                'updated_at' => $this->timestamp(0)->notNull()->defaultExpression('NOW()'),
            ]);

            $this->addPrimaryKey('users_pkey', '{{%users}}', 'primarykey');
//            $this->alterColumn()



            $this->execute('CREATE OR REPLACE FUNCTION trigger_set_timestamp()
                                    RETURNS TRIGGER AS $$
                                    BEGIN
                                      NEW.updated_at = NOW();
                                      RETURN NEW;
                                    END;
                                    $$ LANGUAGE plpgsql;');

            $this->execute('CREATE TRIGGER set_timestamp
                                 BEFORE UPDATE ON users
                                 FOR EACH ROW
                                 EXECUTE PROCEDURE trigger_set_timestamp();');

            $this->createTable('token', [
                'primarykey'   => 'uuid NOT NULL DEFAULT gen_random_uuid()',
                'user'         => 'uuid NOT NULL',
                'token'        => $this->string(50)->notNull(),
                'expired_at'   => $this->timestamp(0)->notNull()->defaultExpression('NOW()'),
                'active'     => $this->boolean()->notNull()->defaultValue(true),
            ]);

            $transaction->commit();
            //$transaction->rollBack();

        } catch (Exception $e) {
            echo 'Exception: ' . $e->getMessage() . '\n';
            $transaction->rollback();
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $this->dropTable('{{%users}}');
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            echo $e->getMessage();
            echo "\n";
            echo get_called_class() . ' cannot be reverted.';
            echo "\n";

            return false;
        }

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220328_074754_new cannot be reverted.\n";

        return false;
    }
    */
}
