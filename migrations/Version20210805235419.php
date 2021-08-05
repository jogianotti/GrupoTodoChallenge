<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210805235419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE producto_categorias CHANGE id id BIGINT AUTO_INCREMENT NOT NULL, CHANGE id_producto id_producto BIGINT NOT NULL, CHANGE id_categoria id_categoria BIGINT NOT NULL');
        $this->addSql('ALTER TABLE producto_categorias ADD CONSTRAINT FK_85D2DB0FF760EA80 FOREIGN KEY (id_producto) REFERENCES productos (id)');
        $this->addSql('ALTER TABLE producto_categorias ADD CONSTRAINT FK_85D2DB0FCE25AE0A FOREIGN KEY (id_categoria) REFERENCES categorias (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_85D2DB0FF760EA80 ON producto_categorias (id_producto)');
        $this->addSql('CREATE INDEX IDX_85D2DB0FCE25AE0A ON producto_categorias (id_categoria)');
        $this->addSql('ALTER TABLE productos CHANGE id id BIGINT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE producto_categorias DROP FOREIGN KEY FK_85D2DB0FF760EA80');
        $this->addSql('ALTER TABLE producto_categorias DROP FOREIGN KEY FK_85D2DB0FCE25AE0A');
        $this->addSql('DROP INDEX UNIQ_85D2DB0FF760EA80 ON producto_categorias');
        $this->addSql('DROP INDEX IDX_85D2DB0FCE25AE0A ON producto_categorias');
        $this->addSql('ALTER TABLE producto_categorias CHANGE id id BIGINT NOT NULL, CHANGE id_producto id_producto BIGINT DEFAULT NULL, CHANGE id_categoria id_categoria BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE productos CHANGE id id BIGINT NOT NULL');
    }
}
