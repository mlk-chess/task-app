<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825142346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_task ADD owner_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE list_task ADD CONSTRAINT FK_17B004CC8FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17B004CC8FDDAB70 ON list_task (owner_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE list_task DROP CONSTRAINT FK_17B004CC8FDDAB70');
        $this->addSql('DROP INDEX IDX_17B004CC8FDDAB70');
        $this->addSql('ALTER TABLE list_task DROP owner_id_id');
    }
}
