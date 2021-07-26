<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210723141138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE `users` (
            `id` BIGINT AUTO_INCREMENT NOT NULL,
            `email` VARCHAR(180) NOT NULL,
            `roles` TEXT NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            UNIQUE INDEX email (email),
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');

    }

    public function postUp(Schema $schema): void
    {

        $enc = new BCryptPasswordEncoder(10);
        $password = $enc->encodePassword('123456', null);
        $item = [
            'email' => 'hernan@grupotodo.com.ar',
            'password' => $password,
            'roles' => '[]'
        ];
        $this->connection->insert('users', $item);

    }

    public function down(Schema $schema): void
    {

        $this->addSql('DROP TABLE `users`');

    }
}
