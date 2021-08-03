<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803023856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE categorias ADD parent_id BIGINT DEFAULT NULL, CHANGE id id BIGINT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE categorias ADD CONSTRAINT FK_5E9F836C727ACA70 FOREIGN KEY (parent_id) REFERENCES categorias (id)');
        $this->addSql('CREATE INDEX IDX_5E9F836C727ACA70 ON categorias (parent_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE categorias DROP FOREIGN KEY FK_5E9F836C727ACA70');
        $this->addSql('DROP INDEX IDX_5E9F836C727ACA70 ON categorias');
        $this->addSql('ALTER TABLE categorias DROP parent_id, CHANGE id id BIGINT NOT NULL');
    }
}
