<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151010011903 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql(
            'CREATE TABLE `session` (
              `id` VARBINARY(128) NOT NULL PRIMARY KEY,
              `data` BLOB NOT NULL,
              `time` INTEGER UNSIGNED NOT NULL,
              `lifetime` MEDIUMINT NOT NULL
            ) ENGINE=InnoDB COLLATE utf8_bin;'
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `session`');
    }
}
