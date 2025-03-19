<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250217110706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE member_event (member_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_598F9F547597D3FE (member_id), INDEX IDX_598F9F5471F7E88B (event_id), PRIMARY KEY(member_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE member_event ADD CONSTRAINT FK_598F9F547597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_event ADD CONSTRAINT FK_598F9F5471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member_event DROP FOREIGN KEY FK_598F9F547597D3FE');
        $this->addSql('ALTER TABLE member_event DROP FOREIGN KEY FK_598F9F5471F7E88B');
        $this->addSql('DROP TABLE member_event');
    }
}
