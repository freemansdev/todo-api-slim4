<?php


use Phinx\Migration\AbstractMigration;

class CreateTagTable extends AbstractMigration
{

    public function up()
    {
        $this->execute(<<<SQL
            CREATE TABLE `tag` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
                PRIMARY KEY (`id`) USING BTREE,
                UNIQUE INDEX `name` (`name`) USING BTREE
            );
SQL
        );
    }

    public function down()
    {
        $this->execute("DROP TABLE `tag`;");
    }
}
