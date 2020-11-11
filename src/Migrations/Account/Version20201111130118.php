<?php

declare(strict_types=1);

namespace AccountDoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111130118 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE account_user (user_id SERIAL NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(user_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10051E3F85E0677 ON account_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10051E3E7927C74 ON account_user (email)');
        $this->addSql('COMMENT ON COLUMN account_user.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE account_user');
    }
}
