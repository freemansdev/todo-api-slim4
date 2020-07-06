<?php


use Phinx\Migration\AbstractMigration;

class CreateTaskTable extends AbstractMigration
{

    public function up()
    {
        $this->execute(<<<SQL
            CREATE TABLE `task` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
                `description` VARCHAR(255) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
                `project` INT(11) NULL DEFAULT NULL,
                `createdAt` TIMESTAMP NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`) USING BTREE
            );
SQL
        );
    }

    public function down()
    {
        $this->execute("DROP TABLE `task`;");
    }
}
