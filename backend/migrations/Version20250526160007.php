<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526160007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE message (id SERIAL NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B6BD307FF624B39D ON message (sender_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B6BD307FCD53EDB6 ON message (receiver_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN message.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP CONSTRAINT FK_B6BD307FF624B39D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP CONSTRAINT FK_B6BD307FCD53EDB6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message
        SQL);
    }
}
