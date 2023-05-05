<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503030259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3316995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3316995AC4C ON book (editor_id)');
        $this->addSql('ALTER TABLE `reads` ADD book_id INT NOT NULL');
        $this->addSql('ALTER TABLE `reads` ADD CONSTRAINT FK_C8406CB116A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_C8406CB116A2B381 ON `reads` (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3316995AC4C');
        $this->addSql('DROP INDEX IDX_CBE5A3316995AC4C ON book');
        $this->addSql('ALTER TABLE `reads` DROP FOREIGN KEY FK_C8406CB116A2B381');
        $this->addSql('DROP INDEX IDX_C8406CB116A2B381 ON `reads`');
        $this->addSql('ALTER TABLE `reads` DROP book_id');
    }
}
