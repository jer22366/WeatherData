<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220821034539 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE oneWeekWeather (id INT AUTO_INCREMENT NOT NULL, one_week_city_id INT NOT NULL, description VARCHAR(255) NOT NULL, max_t INT NOT NULL, min_t INT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rain CHANGE rain_date rain_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tempnow CHANGE time_now time_now DATETIME NOT NULL');
        $this->addSql('ALTER TABLE twodayweather CHANGE start_time start_time DATETIME NOT NULL, CHANGE end_time end_time DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE oneWeekWeather');
        $this->addSql('ALTER TABLE rain CHANGE rain_date rain_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tempNow CHANGE time_now time_now DATETIME NOT NULL');
        $this->addSql('ALTER TABLE twoDayWeather CHANGE start_time start_time DATETIME NOT NULL, CHANGE end_time end_time DATETIME NOT NULL');
    }
}
