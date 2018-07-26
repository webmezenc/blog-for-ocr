<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180726095732 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE associated_media (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE asssociated_media (id INT AUTO_INCREMENT NOT NULL, id_media_id INT NOT NULL, INDEX IDX_32B582F3BA4431E0 (id_media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_options (id INT AUTO_INCREMENT NOT NULL, id_type_blog_id INT NOT NULL, value VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3CC34704D1006410 (id_type_blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, id_post_id INT NOT NULL, id_user_id INT NOT NULL, date_create DATETIME NOT NULL, date_validation DATETIME DEFAULT NULL, content LONGTEXT NOT NULL, state INT NOT NULL, INDEX IDX_5F9E962A9514AA5C (id_post_id), INDEX IDX_5F9E962A79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, id_type_media_id INT NOT NULL, path VARCHAR(250) NOT NULL, date_upload DATETIME NOT NULL, INDEX IDX_6A2CA10C99482BEC (id_type_media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_associated (id INT AUTO_INCREMENT NOT NULL, id_media_id INT NOT NULL, post_id INT NOT NULL, date_adding DATETIME NOT NULL, INDEX IDX_D9F09E42BA4431E0 (id_media_id), INDEX IDX_D9F09E424B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, id_post_category_id INT NOT NULL, id_user_id INT NOT NULL, state SMALLINT NOT NULL, date_create DATETIME NOT NULL, date_update DATETIME DEFAULT NULL, slug VARCHAR(200) NOT NULL, title VARCHAR(250) NOT NULL, headcontent LONGTEXT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_5A8A6C8D1D8C421C (id_post_category_id), INDEX IDX_5A8A6C8D79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_category (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(200) NOT NULL, name VARCHAR(250) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_network (id INT AUTO_INCREMENT NOT NULL, id_type_social_network_id INT NOT NULL, value VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_EFFF522146A1925F (id_type_social_network_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_blog_options (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(200) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, slug VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_social_network (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, icon_class_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(200) NOT NULL, lastname VARCHAR(200) NOT NULL, email VARCHAR(250) NOT NULL, password VARCHAR(255) NOT NULL, state SMALLINT NOT NULL, level SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asssociated_media ADD CONSTRAINT FK_32B582F3BA4431E0 FOREIGN KEY (id_media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE blog_options ADD CONSTRAINT FK_3CC34704D1006410 FOREIGN KEY (id_type_blog_id) REFERENCES type_blog_options (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A9514AA5C FOREIGN KEY (id_post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C99482BEC FOREIGN KEY (id_type_media_id) REFERENCES type_media (id)');
        $this->addSql('ALTER TABLE media_associated ADD CONSTRAINT FK_D9F09E42BA4431E0 FOREIGN KEY (id_media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE media_associated ADD CONSTRAINT FK_D9F09E424B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D1D8C421C FOREIGN KEY (id_post_category_id) REFERENCES post_category (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE social_network ADD CONSTRAINT FK_EFFF522146A1925F FOREIGN KEY (id_type_social_network_id) REFERENCES type_social_network (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE asssociated_media DROP FOREIGN KEY FK_32B582F3BA4431E0');
        $this->addSql('ALTER TABLE media_associated DROP FOREIGN KEY FK_D9F09E42BA4431E0');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A9514AA5C');
        $this->addSql('ALTER TABLE media_associated DROP FOREIGN KEY FK_D9F09E424B89032C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D1D8C421C');
        $this->addSql('ALTER TABLE blog_options DROP FOREIGN KEY FK_3CC34704D1006410');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C99482BEC');
        $this->addSql('ALTER TABLE social_network DROP FOREIGN KEY FK_EFFF522146A1925F');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A79F37AE5');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D79F37AE5');
        $this->addSql('DROP TABLE associated_media');
        $this->addSql('DROP TABLE asssociated_media');
        $this->addSql('DROP TABLE blog_options');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE media_associated');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP TABLE social_network');
        $this->addSql('DROP TABLE type_blog_options');
        $this->addSql('DROP TABLE type_media');
        $this->addSql('DROP TABLE type_social_network');
        $this->addSql('DROP TABLE user');
    }
}
