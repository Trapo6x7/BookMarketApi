<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225154800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anounce DROP FOREIGN KEY FK_F4910DAE16A2B381');
        $this->addSql('ALTER TABLE anounce DROP FOREIGN KEY FK_F4910DAEA76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939816A2B381');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986C755722');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988DE820D9');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398E420DE70');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE anounce');
        $this->addSql('DROP TABLE order_state');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE `condition`');
        $this->addSql('ALTER TABLE book DROP isbn');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE anounce (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, user_id INT DEFAULT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, image_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_F4910DAE16A2B381 (book_id), INDEX IDX_F4910DAEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_state (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, buyer_id INT NOT NULL, seller_id INT NOT NULL, book_id INT NOT NULL, order_state_id INT NOT NULL, purchase_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_F529939816A2B381 (book_id), INDEX IDX_F52993986C755722 (buyer_id), INDEX IDX_F52993988DE820D9 (seller_id), INDEX IDX_F5299398E420DE70 (order_state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, body LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `condition` (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE anounce ADD CONSTRAINT FK_F4910DAE16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE anounce ADD CONSTRAINT FK_F4910DAEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939816A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986C755722 FOREIGN KEY (buyer_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E420DE70 FOREIGN KEY (order_state_id) REFERENCES order_state (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE book ADD isbn VARCHAR(255) NOT NULL');
    }
}
