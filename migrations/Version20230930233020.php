<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230930233020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, position_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, INDEX IDX_BA82C300DD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hoursworked (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, mission_id INT NOT NULL, period VARCHAR(255) NOT NULL, number_hours NUMERIC(4, 2) NOT NULL, work_days DATE NOT NULL, INDEX IDX_F219E83D8C03F15C (employee_id), INDEX IDX_F219E83DBE6CAE90 (mission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions (id INT AUTO_INCREMENT NOT NULL, objective LONGTEXT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE positions (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, hourly_rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C300DD842E46 FOREIGN KEY (position_id) REFERENCES positions (id)');
        $this->addSql('ALTER TABLE hoursworked ADD CONSTRAINT FK_F219E83D8C03F15C FOREIGN KEY (employee_id) REFERENCES employees (id)');
        $this->addSql('ALTER TABLE hoursworked ADD CONSTRAINT FK_F219E83DBE6CAE90 FOREIGN KEY (mission_id) REFERENCES missions (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C300DD842E46');
        $this->addSql('ALTER TABLE hoursworked DROP FOREIGN KEY FK_F219E83D8C03F15C');
        $this->addSql('ALTER TABLE hoursworked DROP FOREIGN KEY FK_F219E83DBE6CAE90');
        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE hoursworked');
        $this->addSql('DROP TABLE missions');
        $this->addSql('DROP TABLE positions');
    }
}
