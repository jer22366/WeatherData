<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220821033551 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rain (id INT AUTO_INCREMENT NOT NULL, rain_city_id INT NOT NULL, one_hour_rain DOUBLE PRECISION NOT NULL, one_day_rain DOUBLE PRECISION NOT NULL, rain_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tempNow (id INT AUTO_INCREMENT NOT NULL, temp_now_city_id INT NOT NULL, temp DOUBLE PRECISION NOT NULL, time_now DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE twoDayWeather (id INT AUTO_INCREMENT NOT NULL, two_day_city_id INT NOT NULL, description_t INT NOT NULL, description VARCHAR(255) NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE rain');
        $this->addSql('DROP TABLE tempNow');
        $this->addSql('DROP TABLE twoDayWeather');
    }
}
