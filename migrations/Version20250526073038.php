<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526073038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE article ADD author_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article_like ADD author_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article_like ADD CONSTRAINT FK_1C21C7B2F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1C21C7B2F675F31B ON article_like (author_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article_rating ADD author_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article_rating ADD CONSTRAINT FK_B24EB1A2F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B24EB1A2F675F31B ON article_rating (author_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment ADD author_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment DROP author
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article DROP CONSTRAINT FK_23A0E66F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_23A0E66F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article DROP author_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article_rating DROP CONSTRAINT FK_B24EB1A2F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_B24EB1A2F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article_rating DROP author_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article_like DROP CONSTRAINT FK_1C21C7B2F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_1C21C7B2F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE article_like DROP author_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment DROP CONSTRAINT FK_9474526CF675F31B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_9474526CF675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment ADD author VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment DROP author_id
        SQL);
    }
}
