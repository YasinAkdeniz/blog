<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308131013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ayarlar (id INT AUTO_INCREMENT NOT NULL, ayarid INT NOT NULL, ayar_logo VARCHAR(255) NOT NULL, ayar_siteurl VARCHAR(255) NOT NULL, ayar_title VARCHAR(255) NOT NULL, ayar_description VARCHAR(255) NOT NULL, ayar_keyword VARCHAR(255) NOT NULL, ayar_author VARCHAR(255) NOT NULL, ayar_facebook VARCHAR(255) NOT NULL, ayar_twitter VARCHAR(255) NOT NULL, ayar_youtube VARCHAR(255) NOT NULL, ayar_linkedin VARCHAR(255) NOT NULL, ayar_instagram VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ayarlar');
    }
}
