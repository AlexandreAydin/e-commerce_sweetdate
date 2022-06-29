<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629082957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adress (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) NOT NULL, postal VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_5CECC7BEA76ED395 ON adress (user_id)');
        $this->addSql('CREATE TABLE carrier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE cart (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B7A76ED395 ON cart (user_id)');
        $this->addSql('CREATE TABLE cart_product (cart_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(cart_id, product_id))');
        $this->addSql('CREATE INDEX IDX_2890CCAA1AD5CDBF ON cart_product (cart_id)');
        $this->addSql('CREATE INDEX IDX_2890CCAA4584665A ON cart_product (product_id)');
        $this->addSql('CREATE TABLE categry (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE header (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content CLOB NOT NULL, btn_title VARCHAR(255) NOT NULL, btn_url VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, created_at DATETIME NOT NULL, carrier_name VARCHAR(255) NOT NULL, carrier_price DOUBLE PRECISION NOT NULL, delivery CLOB NOT NULL, reference VARCHAR(255) NOT NULL, stripe_session_id VARCHAR(255) DEFAULT NULL, state INTEGER DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON "order" (user_id)');
        $this->addSql('CREATE TABLE order_details (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, my_order_id INTEGER NOT NULL, product VARCHAR(255) NOT NULL, quantity INTEGER NOT NULL, price DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_845CA2C1BFCDF877 ON order_details (my_order_id)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, categry_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, subtitle VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL, meilleur BOOLEAN NOT NULL, baklawa BOOLEAN DEFAULT NULL, nos_specialites BOOLEAN DEFAULT NULL, autre BOOLEAN DEFAULT NULL, fruit_sec BOOLEAN DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_D34A04AD7A02C1B3 ON product (categry_id)');
        $this->addSql('CREATE TABLE product_product (product_source INTEGER NOT NULL, product_target INTEGER NOT NULL, PRIMARY KEY(product_source, product_target))');
        $this->addSql('CREATE INDEX IDX_2931F1D3DF63ED7 ON product_product (product_source)');
        $this->addSql('CREATE INDEX IDX_2931F1D24136E58 ON product_product (product_target)');
        $this->addSql('CREATE TABLE reset_password (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_B9983CE5A76ED395 ON reset_password (user_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE carrier');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_product');
        $this->addSql('DROP TABLE categry');
        $this->addSql('DROP TABLE header');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_product');
        $this->addSql('DROP TABLE reset_password');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
