<?php

declare(strict_types=1);

namespace AccountDoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118195912 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE issue (issue_id SERIAL NOT NULL, project_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL, fields JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(issue_id))');
        $this->addSql('CREATE INDEX IDX_12AD233E166D1F9C ON issue (project_id)');
        $this->addSql('CREATE INDEX IDX_12AD233EA76ED395 ON issue (user_id)');
        $this->addSql('COMMENT ON COLUMN issue.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN issue.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E166D1F9C FOREIGN KEY (project_id) REFERENCES project (project_id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233EA76ED395 FOREIGN KEY (user_id) REFERENCES account_user (user_id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE issue');
    }
}
