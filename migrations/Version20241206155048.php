<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241206155048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dette_detail DROP CONSTRAINT fk_f1bdf5e8e11400a1');
        $this->addSql('ALTER TABLE dette_detail DROP CONSTRAINT fk_f1bdf5e8d8d003bb');
        $this->addSql('DROP TABLE dette_detail');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE dette_detail (dette_id INT NOT NULL, detail_id INT NOT NULL, PRIMARY KEY(dette_id, detail_id))');
        $this->addSql('CREATE INDEX idx_f1bdf5e8d8d003bb ON dette_detail (detail_id)');
        $this->addSql('CREATE INDEX idx_f1bdf5e8e11400a1 ON dette_detail (dette_id)');
        $this->addSql('ALTER TABLE dette_detail ADD CONSTRAINT fk_f1bdf5e8e11400a1 FOREIGN KEY (dette_id) REFERENCES dette (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dette_detail ADD CONSTRAINT fk_f1bdf5e8d8d003bb FOREIGN KEY (detail_id) REFERENCES detail (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
