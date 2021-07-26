<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210723130251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE `categorias` (
            `id` BIGINT(11) NOT NULL,
            `nombre` VARCHAR(100) NOT NULL,
            `descripcion` TEXT NULL,
            `created_at` DATETIME NOT NULL,
            `updated_at` DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('CREATE TABLE `productos` (
            `id` BIGINT(11) NOT NULL,
            `nombre` VARCHAR(100) NOT NULL,
            `descripcion` TEXT NULL,
            `created_at` DATETIME NOT NULL,
            `updated_at` DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('CREATE TABLE `producto_categorias` (
            `id` BIGINT(11) NOT NULL,
            `id_producto` BIGINT(11),
            `id_categoria` BIGINT(11),
            `created_at` DATETIME NOT NULL,
            `updated_at` DATETIME NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql('ALTER TABLE `categorias` ADD PRIMARY KEY (`id`);');
        $this->addSql('ALTER TABLE `productos` ADD PRIMARY KEY (`id`);');
        $this->addSql('ALTER TABLE `producto_categorias` ADD PRIMARY KEY (`id`);');

    }

    public function down(Schema $schema): void
    {

        $this->addSql('DROP TABLE `categorias`');
        $this->addSql('DROP TABLE `productos`');
        $this->addSql('DROP TABLE `producto_categorias`');

    }
}
