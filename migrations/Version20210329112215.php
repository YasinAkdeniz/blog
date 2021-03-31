<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329112215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_tag_blog (blog_tag_id INT NOT NULL, blog_id INT NOT NULL, INDEX IDX_5A47CAD22F9DC6D0 (blog_tag_id), INDEX IDX_5A47CAD2DAE07E97 (blog_id), PRIMARY KEY(blog_tag_id, blog_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_tag_blog ADD CONSTRAINT FK_5A47CAD22F9DC6D0 FOREIGN KEY (blog_tag_id) REFERENCES blog_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_tag_blog ADD CONSTRAINT FK_5A47CAD2DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_tag ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog_tag_blog');
        $this->addSql('ALTER TABLE blog_tag DROP slug');
    }
}
