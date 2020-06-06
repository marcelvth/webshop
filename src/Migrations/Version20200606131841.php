<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200606131841 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE factuur CHANGE klant_id_id klant_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_image CHANGE product_id_id product_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regel CHANGE factuur_id_id factuur_id_id INT DEFAULT NULL, CHANGE product_id_id product_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE factuur CHANGE klant_id_id klant_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_image CHANGE product_id_id product_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regel CHANGE factuur_id_id factuur_id_id INT DEFAULT NULL, CHANGE product_id_id product_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
