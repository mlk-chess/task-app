<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230824115912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE list_task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE list_task (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE list_task_user (list_task_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(list_task_id, user_id))');
        $this->addSql('CREATE INDEX IDX_B3EC4E5951F9DC8B ON list_task_user (list_task_id)');
        $this->addSql('CREATE INDEX IDX_B3EC4E59A76ED395 ON list_task_user (user_id)');
        $this->addSql('ALTER TABLE list_task_user ADD CONSTRAINT FK_B3EC4E5951F9DC8B FOREIGN KEY (list_task_id) REFERENCES list_task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE list_task_user ADD CONSTRAINT FK_B3EC4E59A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE list_task_id_seq CASCADE');
        $this->addSql('ALTER TABLE list_task_user DROP CONSTRAINT FK_B3EC4E5951F9DC8B');
        $this->addSql('ALTER TABLE list_task_user DROP CONSTRAINT FK_B3EC4E59A76ED395');
        $this->addSql('DROP TABLE list_task');
        $this->addSql('DROP TABLE list_task_user');
    }
}
