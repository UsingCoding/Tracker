<?php

declare(strict_types=1);

namespace AccountDoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208191218 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE issue ADD in_project_id INT NOT NULL');
        $this->addSql('ALTER TABLE issue ALTER project_id SET NOT NULL');
        $this->addSql('CREATE INDEX IDX_12AD233E59D0772A ON issue (in_project_id)');
        $this->addSql('CREATE UNIQUE INDEX in_project_id_project_id_unique_index ON issue (in_project_id, project_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_12AD233E59D0772A');
        $this->addSql('DROP INDEX in_project_id_project_id_unique_index');
        $this->addSql('ALTER TABLE issue DROP in_project_id');
        $this->addSql('ALTER TABLE issue ALTER project_id DROP NOT NULL');
    }
}
