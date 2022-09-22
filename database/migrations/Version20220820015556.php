<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220820015556 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE city (city_id INT AUTO_INCREMENT NOT NULL, city VARCHAR(255) NOT NULL, city_img VARCHAR(255) NOT NULL, PRIMARY KEY(city_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('雲林縣','Yunlin.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('南投縣','Nantou.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('連江縣','Lianjiang.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('金門縣','Kinmen.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('宜蘭縣','Yilan.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('屏東縣','Pingtung.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('苗栗縣','Miaoli.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('澎湖縣','Penghu.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('台北市','Taipeicity.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('新竹縣','Hsinchu.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('花蓮縣','Hualien.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('高雄市','Kaohsiungcity.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('彰化縣','Changhua.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('新竹市','Hsinchucity.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('新北市','New Taipeicity.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('基隆市','Keelungcity.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('台中市','Taichungcity.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('台南縣','Tainan.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('桃園市','Taoyuancity.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('嘉義縣','Chiayi.jpeg')");
        $this->addSql("INSERT INTO city(city,city_img) VALUES ('嘉義市','Chiayicity.jpeg')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE city');
    }
}
