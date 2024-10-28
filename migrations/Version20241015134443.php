<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015134443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ad_option (id INT AUTO_INCREMENT NOT NULL, ad_id INT DEFAULT NULL, choice_id INT DEFAULT NULL, value JSON NOT NULL, INDEX IDX_C76917454F34D596 (ad_id), INDEX IDX_C7691745998666D1 (choice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, type VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ad_option ADD CONSTRAINT FK_C76917454F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE ad_option ADD CONSTRAINT FK_C7691745998666D1 FOREIGN KEY (choice_id) REFERENCES `option` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ad_option DROP FOREIGN KEY FK_C76917454F34D596');
        $this->addSql('ALTER TABLE ad_option DROP FOREIGN KEY FK_C7691745998666D1');
        $this->addSql('DROP TABLE ad_option');
        $this->addSql('DROP TABLE `option`');
    }
}
