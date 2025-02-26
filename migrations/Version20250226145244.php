<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226145244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP INDEX UNIQ_F5299398E420DE70, ADD INDEX IDX_F5299398E420DE70 (order_state_id)');
        $this->addSql('ALTER TABLE `order` CHANGE order_state_id order_state_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP INDEX IDX_F5299398E420DE70, ADD UNIQUE INDEX UNIQ_F5299398E420DE70 (order_state_id)');
        $this->addSql('ALTER TABLE `order` CHANGE order_state_id order_state_id INT NOT NULL');
    }
}
