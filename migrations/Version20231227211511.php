<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227211511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_lot (user_id INT NOT NULL, lot_id INT NOT NULL, INDEX IDX_E0974890A76ED395 (user_id), INDEX IDX_E0974890A8CBA5F7 (lot_id), PRIMARY KEY(user_id, lot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_lot ADD CONSTRAINT FK_E0974890A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_lot ADD CONSTRAINT FK_E0974890A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_lot DROP FOREIGN KEY FK_E0974890A76ED395');
        $this->addSql('ALTER TABLE user_lot DROP FOREIGN KEY FK_E0974890A8CBA5F7');
        $this->addSql('DROP TABLE user_lot');
    }
}
