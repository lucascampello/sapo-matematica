<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625051030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE questionario_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE questionario (id INT NOT NULL, professor_id INT NOT NULL, nome VARCHAR(255) NOT NULL, data_inicio DATE NOT NULL, data_fim DATE NOT NULL, conteudo_abordado VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E1E6A7E17D2D84D5 ON questionario (professor_id)');
        $this->addSql('ALTER TABLE questionario ADD CONSTRAINT FK_E1E6A7E17D2D84D5 FOREIGN KEY (professor_id) REFERENCES professor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE questionario_id_seq CASCADE');
        $this->addSql('DROP TABLE questionario');
    }
}
