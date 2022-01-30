<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129203230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sylius_customer_newsletter (customer_id INT NOT NULL, newsletter_id INT NOT NULL, INDEX IDX_9A0FF3329395C3F3 (customer_id), INDEX IDX_9A0FF33222DB1917 (newsletter_id), PRIMARY KEY(customer_id, newsletter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_newsletter (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(127) NOT NULL, subject VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, is_active TINYINT(1) DEFAULT \'1\', createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, UNIQUE INDEX UNIQ_5BDA1D2C8CDE5729 (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_newsletter_log (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', customer_id INT DEFAULT NULL, newsletter_id INT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, UNIQUE INDEX UNIQ_BB20F4739395C3F3 (customer_id), UNIQUE INDEX UNIQ_BB20F47322DB1917 (newsletter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_customer_newsletter ADD CONSTRAINT FK_9A0FF3329395C3F3 FOREIGN KEY (customer_id) REFERENCES sylius_customer (id)');
        $this->addSql('ALTER TABLE sylius_customer_newsletter ADD CONSTRAINT FK_9A0FF33222DB1917 FOREIGN KEY (newsletter_id) REFERENCES sylius_newsletter (id)');
        $this->addSql('ALTER TABLE sylius_newsletter_log ADD CONSTRAINT FK_BB20F4739395C3F3 FOREIGN KEY (customer_id) REFERENCES sylius_customer (id)');
        $this->addSql('ALTER TABLE sylius_newsletter_log ADD CONSTRAINT FK_BB20F47322DB1917 FOREIGN KEY (newsletter_id) REFERENCES sylius_newsletter (id)');

        $this->addSql("insert into sylius_newsletter(type, subject, content, createdAt, updatedAt) values('type A', 'type A subject', 'type A description', now(), now()), ('type B', 'type B subject', 'type B description', now(), now()), ('type C', 'type C subject', 'type C description', now(), now()), ('type D', 'type D subject', 'type D description', now(), now())");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sylius_customer_newsletter DROP FOREIGN KEY FK_9A0FF33222DB1917');
        $this->addSql('ALTER TABLE sylius_newsletter_log DROP FOREIGN KEY FK_BB20F47322DB1917');
        $this->addSql('DROP TABLE sylius_customer_newsletter');
        $this->addSql('DROP TABLE sylius_newsletter');
        $this->addSql('DROP TABLE sylius_newsletter_log');
    }
}
