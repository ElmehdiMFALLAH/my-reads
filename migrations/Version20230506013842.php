<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506013842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add constraint unique_user_book to reads table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `premium_reads`
        ADD CONSTRAINT `unique_user_book`
        UNIQUE (`user_id`, `book_id`)');
    }

    public function down(Schema $schema): void { }
}
