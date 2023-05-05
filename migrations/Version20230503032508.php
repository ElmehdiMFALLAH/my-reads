<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503032508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `premium_reads` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, book_id INT NOT NULL, progress INT DEFAULT NULL, review VARCHAR(500) DEFAULT NULL, INDEX IDX_75C03477A76ED395 (user_id), INDEX IDX_75C0347716A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `premium_reads` ADD CONSTRAINT FK_75C03477A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `premium_reads` ADD CONSTRAINT FK_75C0347716A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE `reads` DROP FOREIGN KEY FK_C8406CB116A2B381');
        $this->addSql('ALTER TABLE `reads` DROP FOREIGN KEY FK_C8406CB1A76ED395');
        $this->addSql('DROP TABLE `reads`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `reads` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, book_id INT NOT NULL, progress INT DEFAULT NULL, review VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_C8406CB1A76ED395 (user_id), INDEX IDX_C8406CB116A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `reads` ADD CONSTRAINT FK_C8406CB116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `reads` ADD CONSTRAINT FK_C8406CB1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `premium_reads` DROP FOREIGN KEY FK_75C03477A76ED395');
        $this->addSql('ALTER TABLE `premium_reads` DROP FOREIGN KEY FK_75C0347716A2B381');
        $this->addSql('DROP TABLE `premium_reads`');
    }
}
