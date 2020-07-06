<?php


use Phinx\Migration\AbstractMigration;

class CreateProjectTable extends AbstractMigration
{

    public function up()
    {
        $this->execute(<<<SQL
            CREATE TABLE `project` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
                `createdAt` TIMESTAMP NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`) USING BTREE
            );
SQL
        );
    }

    public function down()
    {
        $this->execute("DROP TABLE `project`;");
    }
}
