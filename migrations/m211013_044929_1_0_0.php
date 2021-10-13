<?php

use yii\db\Migration;

/**
 * Class m211013_044929_1_0_0
 */
class m211013_044929_1_0_0 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('author', [ 'fio' => 'Matthew Gambardella']);
        $this->insert('author', [ 'fio' => 'Tim O`Brien']);
        $this->insert('author', [ 'fio' => 'Mike Galos']);
        $this->insert('author', [ 'fio' => 'Kim Ralls']);
        $this->insert('author', [ 'fio' => 'Eva Corets']);
        $this->insert('author', [ 'fio' => 'Stefan Knorr']);
        $this->insert('author', [ 'fio' => 'Cynthia Randall']);
        $this->insert('author', [ 'fio' => 'Paula Thurman']);
        $this->insert('author', [ 'fio' => 'Peter Kress']);

        $this->insert('genre', [ 'name' => 'Classic']);
        $this->insert('genre', [ 'name' => 'Tail']);
        $this->insert('genre', [ 'name' => 'Computer']);
        $this->insert('genre', [ 'name' => 'Fantasy']);
        $this->insert('genre', [ 'name' => 'Horror']);
        $this->insert('genre', [ 'name' => 'Romance']);
        $this->insert('genre', [ 'name' => 'Science Fiction']);

        $books = [
            [1, 'XML Developer`s Guide', 3506, 3],
            [1, 'Microsoft .NET: The Programming Bible', 3201, 3],
            [2, 'MSXML3: A Comprehensive Guide', 3201, 3],
            [3, 'Visual Studio 7: A Comprehensive Guide', 3201, 3],
            [4, 'Midnight Rain', 428, 4],
            [5, 'Maeve Ascendant', 428, 6],
            [5, 'Oberon`s Legacy', 428, 4],
            [5, 'The Sundered Grail', 428, 4],
            [6, 'Creepy Crawlies', 356, 5],
            [7, 'Lover Birds', 356, 6],
            [8, 'Splish Splash', 356, 6],
            [9, 'Paradox Lost', 356, 7],
        ];

        $this->batchInsert('book', ['id_author', 'name', 'price', 'id_genre'], $books);

        $users = [
            ['admin', '$2y$13$BPSfIVibw60IAIQQSwXWRuAl.5oPMI33EjJIUqoBFxbMuFXf4iA4q',
                'admin@base.ru', 'admin user', 10],
            ['user', '$2y$13$BPSfIVibw60IAIQQSwXWRuAl.5oPMI33EjJIUqoBFxbMuFXf4iA4q',
                'user@mail.ru',null, 10],
            ['user1', '$2y$13$BPSfIVibw60IAIQQSwXWRuAl.5oPMI33EjJIUqoBFxbMuFXf4iA4q',
             'user1@mail.ru',null, 10],
        ];

        $this->batchInsert('users', ['username', 'password', 'email', 'description', 'status'], $users);

        $tokensArr = [
            [1, '44H67gG2NAuF2Ng0IgnO_ofNJK4iEu13', 1605872540],
            [2, 'ykMp9PKzPv39bDQL78UwsxzZunwVVgO5', 1605872551],
            [1, 'ZI8qMNlQeCdmjraw6wVWE8WlL61QM2-V', 1605872864]
        ];

        foreach ($tokensArr as $token) {
            $this->insert('token', ['user_id' => $token[0], 'token' => $token[1], 'expired_at' => $token[2]]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('token');
        $this->truncateTable('users');
        $this->truncateTable('book');
        $this->truncateTable('genre');
        $this->truncateTable('author');
        return false;
    }
}
