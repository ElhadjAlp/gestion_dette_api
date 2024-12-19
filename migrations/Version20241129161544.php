<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129161544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id SERIAL NOT NULL, libelle VARCHAR(50) DEFAULT NULL, reference VARCHAR(50) DEFAULT NULL, qte_stock INT DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE detail (id SERIAL NOT NULL, article_id INT DEFAULT NULL, dette_id INT DEFAULT NULL, prix_vente DOUBLE PRECISION DEFAULT NULL, qte_vendu INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2E067F937294869C ON detail (article_id)');
        $this->addSql('CREATE INDEX IDX_2E067F93E11400A1 ON detail (dette_id)');
        $this->addSql('CREATE TABLE dette (id SERIAL NOT NULL, client_id INT DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, montant_verser DOUBLE PRECISION DEFAULT NULL, montant_restant DOUBLE PRECISION DEFAULT NULL, date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_831BC80819EB6921 ON dette (client_id)');
        $this->addSql('CREATE TABLE dette_detail (dette_id INT NOT NULL, detail_id INT NOT NULL, PRIMARY KEY(dette_id, detail_id))');
        $this->addSql('CREATE INDEX IDX_F1BDF5E8E11400A1 ON dette_detail (dette_id)');
        $this->addSql('CREATE INDEX IDX_F1BDF5E8D8D003BB ON dette_detail (detail_id)');
        $this->addSql('CREATE TABLE payment (id SERIAL NOT NULL, yes_id INT DEFAULT NULL, date DATE DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D28840D2CB716C7 ON payment (yes_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, client_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64919EB6921 ON "user" (client_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F937294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93E11400A1 FOREIGN KEY (dette_id) REFERENCES dette (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT FK_831BC80819EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dette_detail ADD CONSTRAINT FK_F1BDF5E8E11400A1 FOREIGN KEY (dette_id) REFERENCES dette (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dette_detail ADD CONSTRAINT FK_F1BDF5E8D8D003BB FOREIGN KEY (detail_id) REFERENCES detail (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D2CB716C7 FOREIGN KEY (yes_id) REFERENCES dette (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE detail DROP CONSTRAINT FK_2E067F937294869C');
        $this->addSql('ALTER TABLE detail DROP CONSTRAINT FK_2E067F93E11400A1');
        $this->addSql('ALTER TABLE dette DROP CONSTRAINT FK_831BC80819EB6921');
        $this->addSql('ALTER TABLE dette_detail DROP CONSTRAINT FK_F1BDF5E8E11400A1');
        $this->addSql('ALTER TABLE dette_detail DROP CONSTRAINT FK_F1BDF5E8D8D003BB');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D2CB716C7');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64919EB6921');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE detail');
        $this->addSql('DROP TABLE dette');
        $this->addSql('DROP TABLE dette_detail');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE "user"');
    }
}
