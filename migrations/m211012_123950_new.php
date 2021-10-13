<?php

use yii\db\Migration;

/**
 * Class m211012_123950_new
 */
class m211012_123950_new extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('author', [
                'id'  => $this->primaryKey(),
                'fio' => $this->string(50)->null()
            ]);

        $this->createTable('genre', [
                'id'   => $this->primaryKey(),
                'name' => $this->string(50)->notNull()
            ]);

        $this->createTable('book', [
                'id'        => $this->primaryKey(),
                'id_author' => $this->integer(11)->notNull(),
                'name'      => $this->string(255)->notNull(),
                'price'     => $this->integer(11)->defaultValue(2000),
                'id_genre'  => $this->integer(11)->notNull()
            ]);

        $this->addForeignKey(
            'fk_author',
            'book',
            'id_author',
            'author',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_genre',
            'book',
            'id_genre',
            'genre',
            'id',
            'CASCADE'
        );

        $this->createTable('users', [
                'id'          => $this->primaryKey(),
                'username'    => $this->string(255)->notNull(),
                'password'    => $this->string(512)->notNull(),
                'email'       => $this->string(255)->notNull(),
                'description' => $this->string(255)->defaultValue(null),
                'status'      => $this->integer(11)->defaultValue(10),
                'created_at'  => $this->integer(11)->defaultValue(null),
                'updated_at'  => $this->integer(11)->defaultValue(null)
            ]);

        $this->createTable('token', [
                'id'         => $this->primaryKey(),
                'user_id'    => $this->integer(11)->notNull(),
                'token'      => $this->string(255)->notNull(),
                'expired_at' => $this->integer(11)->notNull()
            ]);

        $this->addForeignKey(
            'idx-token-user_id',
            'token',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('token');
        $this->dropTable('users');
        $this->dropTable('books');
        $this->dropTable('genre');
        $this->dropTable('author');
        return false;
    }
}
