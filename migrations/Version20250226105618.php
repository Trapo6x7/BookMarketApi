<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226105618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE anounce (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, state_id INT NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, image_url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F4910DAE16A2B381 (book_id), INDEX IDX_F4910DAE5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `condition` (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anounce ADD CONSTRAINT FK_F4910DAE16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE anounce ADD CONSTRAINT FK_F4910DAE5D83CC1 FOREIGN KEY (state_id) REFERENCES `condition` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anounce DROP FOREIGN KEY FK_F4910DAE16A2B381');
        $this->addSql('ALTER TABLE anounce DROP FOREIGN KEY FK_F4910DAE5D83CC1');
        $this->addSql('DROP TABLE anounce');
        $this->addSql('DROP TABLE `condition`');
    }
}
