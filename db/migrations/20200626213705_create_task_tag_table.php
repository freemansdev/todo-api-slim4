<?php


use Phinx\Migration\AbstractMigration;

class CreateTaskTagTable extends AbstractMigration
{

    public function up()
    {
        $this->execute(<<<SQL
            CREATE TABLE `task_tag` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `task` INT(11) NOT NULL,
                `tag` INT(11) NOT NULL,
                PRIMARY KEY (`id`) USING BTREE,
                UNIQUE INDEX `task_tag` (`task`, `tag`) USING BTREE
            );
SQL
        );
    }

    public function down()
    {
        $this->execute("DROP TABLE `task_tag`;");
    }
}
