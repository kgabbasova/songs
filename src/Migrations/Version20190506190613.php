<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190506190613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, title VARCHAR(64) NOT NULL, genre VARCHAR(64) DEFAULT NULL, singer VARCHAR(64) NOT NULL, duration TIME DEFAULT NULL, likes_amount INT DEFAULT NULL, dislikes_amount INT DEFAULT NULL, INDEX IDX_33EDEEA17E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song_dislikes (id INT AUTO_INCREMENT NOT NULL, song_id INT NOT NULL, user_disliked_id INT NOT NULL, INDEX IDX_862FE859A0BDB2F3 (song_id), INDEX IDX_862FE85941828A79 (user_disliked_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song_like (id INT AUTO_INCREMENT NOT NULL, song_id INT NOT NULL, user_liked_id INT NOT NULL, INDEX IDX_DFF09646A0BDB2F3 (song_id), INDEX IDX_DFF09646260FC79 (user_liked_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA17E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE song_dislikes ADD CONSTRAINT FK_862FE859A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE song_dislikes ADD CONSTRAINT FK_862FE85941828A79 FOREIGN KEY (user_disliked_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE song_like ADD CONSTRAINT FK_DFF09646A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE song_like ADD CONSTRAINT FK_DFF09646260FC79 FOREIGN KEY (user_liked_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE song_dislikes DROP FOREIGN KEY FK_862FE859A0BDB2F3');
        $this->addSql('ALTER TABLE song_like DROP FOREIGN KEY FK_DFF09646A0BDB2F3');
        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA17E3C61F9');
        $this->addSql('ALTER TABLE song_dislikes DROP FOREIGN KEY FK_862FE85941828A79');
        $this->addSql('ALTER TABLE song_like DROP FOREIGN KEY FK_DFF09646260FC79');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE song_dislikes');
        $this->addSql('DROP TABLE song_like');
        $this->addSql('DROP TABLE user');
    }
}
