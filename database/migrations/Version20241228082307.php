<?php

declare(strict_types=1);

namespace Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241228082307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE analytic_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE analytics (id INT AUTO_INCREMENT NOT NULL, analytic_category_id INT NOT NULL, data JSON NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EAC2E6887C82B010 (analytic_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attributes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, data JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, children_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, image LONGTEXT DEFAULT NULL, meta_keyword VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, status INT DEFAULT 0 NOT NULL, INDEX IDX_3AF346683D3D2749 (children_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE communes (id INT AUTO_INCREMENT NOT NULL, district_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, latitude NUMERIC(65, 8) NOT NULL, longitude NUMERIC(65, 8) NOT NULL, INDEX IDX_5C5EE2A5B08FA272 (district_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, body VARCHAR(500) NOT NULL, status SMALLINT NOT NULL, opened_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', replied_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', rejected_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_33401573A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coupons (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, limit_quantity INT NOT NULL, per_customer INT NOT NULL, expired_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE districts (id INT AUTO_INCREMENT NOT NULL, province_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, latitude NUMERIC(65, 8) NOT NULL, longitude NUMERIC(65, 8) NOT NULL, INDEX IDX_68E318DCE946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `groups` (id INT AUTO_INCREMENT NOT NULL, children_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_F06D39703D3D2749 (children_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventories (id INT AUTO_INCREMENT NOT NULL, commune_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(500) NOT NULL, postal_code VARCHAR(10) NOT NULL, type SMALLINT NOT NULL, priority INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_936C863D131A4F72 (commune_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loyalties (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, point INT NOT NULL, note VARCHAR(500) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C1D27F42A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loyalties_coupons (id INT AUTO_INCREMENT NOT NULL, loyalty_id INT NOT NULL, coupon_id INT NOT NULL, INDEX IDX_7B37E978C906750D (loyalty_id), INDEX IDX_7B37E97866C5951B (coupon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, subject VARCHAR(255) NOT NULL, body VARCHAR(500) NOT NULL, start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6000B0D3F624B39D (sender_id), INDEX IDX_6000B0D3CD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_combo_items (id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, child_ids JSON NOT NULL, discount_amount NUMERIC(65, 2) NOT NULL, discount_type INT NOT NULL, INDEX IDX_B68AD97C727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_reviews (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, comment VARCHAR(500) NOT NULL, rating INT NOT NULL, status INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B8A9F0BF4584665A (product_id), INDEX IDX_B8A9F0BFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variant_images (id INT AUTO_INCREMENT NOT NULL, product_variant_id INT NOT NULL, image LONGTEXT NOT NULL, position INT NOT NULL, INDEX IDX_A62C6790A80EF684 (product_variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variants (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, price NUMERIC(65, 2) NOT NULL, is_on_sale INT DEFAULT 0 NOT NULL, sale_price NUMERIC(65, 2) DEFAULT NULL, sale_start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', sale_end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', stock INT NOT NULL, position INT NOT NULL, INDEX IDX_782839764584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variants_attributes (id INT AUTO_INCREMENT NOT NULL, product_variant_id INT NOT NULL, attribute_id INT NOT NULL, INDEX IDX_963DF5D4A80EF684 (product_variant_id), INDEX IDX_963DF5D4B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variants_inventories (id INT AUTO_INCREMENT NOT NULL, inventory_id INT NOT NULL, product_variant_id INT NOT NULL, stock INT NOT NULL, INDEX IDX_427047A79EEA759 (inventory_id), INDEX IDX_427047A7A80EF684 (product_variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variants_sale_events (id INT AUTO_INCREMENT NOT NULL, product_variant_id INT NOT NULL, sale_event_id INT NOT NULL, INDEX IDX_F6FA9812A80EF684 (product_variant_id), INDEX IDX_F6FA98126F830421 (sale_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, supplier_id INT NOT NULL, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, short_description VARCHAR(500) NOT NULL, description LONGTEXT NOT NULL, original_price NUMERIC(65, 2) NOT NULL, type INT NOT NULL, thumbnail LONGTEXT DEFAULT NULL, meta_keyword VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, status INT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B3BA5A5A2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_categories (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_E8ACBE7612469DE2 (category_id), INDEX IDX_E8ACBE764584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_tags (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E3AB5A2C4584665A (product_id), INDEX IDX_E3AB5A2CBAD26311 (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provinces (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, latitude NUMERIC(65, 8) NOT NULL, longitude NUMERIC(65, 8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_products (id INT AUTO_INCREMENT NOT NULL, from_target_id INT NOT NULL, target_id INT NOT NULL, INDEX IDX_153914F75129EDC (from_target_id), INDEX IDX_153914F7158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_events (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, discount_amount NUMERIC(65, 2) NOT NULL, discount_type INT NOT NULL, start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_events_meta (id INT AUTO_INCREMENT NOT NULL, sale_event_id INT NOT NULL, meta_key VARCHAR(255) NOT NULL, meta_value JSON NOT NULL, INDEX IDX_CAEEC1226F830421 (sale_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, data JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier_meta (id INT AUTO_INCREMENT NOT NULL, supplier_id INT NOT NULL, meta_key VARCHAR(255) NOT NULL, meta_value JSON NOT NULL, INDEX IDX_1AAAE2DC2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suppliers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, slug VARCHAR(255) NOT NULL, meta_keyword VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_addresses (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, commune_id INT NOT NULL, address VARCHAR(500) NOT NULL, postal_code VARCHAR(10) NOT NULL, type INT NOT NULL, INDEX IDX_6F2AF8F2A76ED395 (user_id), UNIQUE INDEX UNIQ_6F2AF8F2131A4F72 (commune_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_agents (id INT AUTO_INCREMENT NOT NULL, data JSON NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profiles (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, gender INT NOT NULL, dob DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(15) NOT NULL, avatar LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_6BBD6130A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, children_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, status INT DEFAULT 0 NOT NULL, email_verified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', blocked_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1483A5E93D3D2749 (children_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_groups (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_FF8AB7E0A76ED395 (user_id), INDEX IDX_FF8AB7E0FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wishlist (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_9CE12A31A76ED395 (user_id), INDEX IDX_9CE12A314584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE analytics ADD CONSTRAINT FK_EAC2E6887C82B010 FOREIGN KEY (analytic_category_id) REFERENCES analytic_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346683D3D2749 FOREIGN KEY (children_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A5B08FA272 FOREIGN KEY (district_id) REFERENCES districts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_33401573A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE districts ADD CONSTRAINT FK_68E318DCE946114A FOREIGN KEY (province_id) REFERENCES provinces (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `groups` ADD CONSTRAINT FK_F06D39703D3D2749 FOREIGN KEY (children_id) REFERENCES `groups` (id)');
        $this->addSql('ALTER TABLE inventories ADD CONSTRAINT FK_936C863D131A4F72 FOREIGN KEY (commune_id) REFERENCES communes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loyalties ADD CONSTRAINT FK_C1D27F42A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loyalties_coupons ADD CONSTRAINT FK_7B37E978C906750D FOREIGN KEY (loyalty_id) REFERENCES loyalties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loyalties_coupons ADD CONSTRAINT FK_7B37E97866C5951B FOREIGN KEY (coupon_id) REFERENCES coupons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D3F624B39D FOREIGN KEY (sender_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D3CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_combo_items ADD CONSTRAINT FK_B68AD97C727ACA70 FOREIGN KEY (parent_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_reviews ADD CONSTRAINT FK_B8A9F0BF4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_reviews ADD CONSTRAINT FK_B8A9F0BFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_variant_images ADD CONSTRAINT FK_A62C6790A80EF684 FOREIGN KEY (product_variant_id) REFERENCES product_variants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_variants ADD CONSTRAINT FK_782839764584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_variants_attributes ADD CONSTRAINT FK_963DF5D4A80EF684 FOREIGN KEY (product_variant_id) REFERENCES product_variants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_variants_attributes ADD CONSTRAINT FK_963DF5D4B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attributes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_variants_inventories ADD CONSTRAINT FK_427047A79EEA759 FOREIGN KEY (inventory_id) REFERENCES inventories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_variants_inventories ADD CONSTRAINT FK_427047A7A80EF684 FOREIGN KEY (product_variant_id) REFERENCES product_variants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_variants_sale_events ADD CONSTRAINT FK_F6FA9812A80EF684 FOREIGN KEY (product_variant_id) REFERENCES product_variants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_variants_sale_events ADD CONSTRAINT FK_F6FA98126F830421 FOREIGN KEY (sale_event_id) REFERENCES sale_events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES suppliers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_categories ADD CONSTRAINT FK_E8ACBE7612469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_categories ADD CONSTRAINT FK_E8ACBE764584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_tags ADD CONSTRAINT FK_E3AB5A2C4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_tags ADD CONSTRAINT FK_E3AB5A2CBAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id)');
        $this->addSql('ALTER TABLE related_products ADD CONSTRAINT FK_153914F75129EDC FOREIGN KEY (from_target_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_products ADD CONSTRAINT FK_153914F7158E0B66 FOREIGN KEY (target_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale_events_meta ADD CONSTRAINT FK_CAEEC1226F830421 FOREIGN KEY (sale_event_id) REFERENCES sale_events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE supplier_meta ADD CONSTRAINT FK_1AAAE2DC2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES suppliers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_addresses ADD CONSTRAINT FK_6F2AF8F2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_addresses ADD CONSTRAINT FK_6F2AF8F2131A4F72 FOREIGN KEY (commune_id) REFERENCES communes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_profiles ADD CONSTRAINT FK_6BBD6130A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E93D3D2749 FOREIGN KEY (children_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES `groups` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A314584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analytics DROP FOREIGN KEY FK_EAC2E6887C82B010');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346683D3D2749');
        $this->addSql('ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A5B08FA272');
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573A76ED395');
        $this->addSql('ALTER TABLE districts DROP FOREIGN KEY FK_68E318DCE946114A');
        $this->addSql('ALTER TABLE `groups` DROP FOREIGN KEY FK_F06D39703D3D2749');
        $this->addSql('ALTER TABLE inventories DROP FOREIGN KEY FK_936C863D131A4F72');
        $this->addSql('ALTER TABLE loyalties DROP FOREIGN KEY FK_C1D27F42A76ED395');
        $this->addSql('ALTER TABLE loyalties_coupons DROP FOREIGN KEY FK_7B37E978C906750D');
        $this->addSql('ALTER TABLE loyalties_coupons DROP FOREIGN KEY FK_7B37E97866C5951B');
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D3F624B39D');
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D3CD53EDB6');
        $this->addSql('ALTER TABLE product_combo_items DROP FOREIGN KEY FK_B68AD97C727ACA70');
        $this->addSql('ALTER TABLE product_reviews DROP FOREIGN KEY FK_B8A9F0BF4584665A');
        $this->addSql('ALTER TABLE product_reviews DROP FOREIGN KEY FK_B8A9F0BFA76ED395');
        $this->addSql('ALTER TABLE product_variant_images DROP FOREIGN KEY FK_A62C6790A80EF684');
        $this->addSql('ALTER TABLE product_variants DROP FOREIGN KEY FK_782839764584665A');
        $this->addSql('ALTER TABLE product_variants_attributes DROP FOREIGN KEY FK_963DF5D4A80EF684');
        $this->addSql('ALTER TABLE product_variants_attributes DROP FOREIGN KEY FK_963DF5D4B6E62EFA');
        $this->addSql('ALTER TABLE product_variants_inventories DROP FOREIGN KEY FK_427047A79EEA759');
        $this->addSql('ALTER TABLE product_variants_inventories DROP FOREIGN KEY FK_427047A7A80EF684');
        $this->addSql('ALTER TABLE product_variants_sale_events DROP FOREIGN KEY FK_F6FA9812A80EF684');
        $this->addSql('ALTER TABLE product_variants_sale_events DROP FOREIGN KEY FK_F6FA98126F830421');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A2ADD6D8C');
        $this->addSql('ALTER TABLE products_categories DROP FOREIGN KEY FK_E8ACBE7612469DE2');
        $this->addSql('ALTER TABLE products_categories DROP FOREIGN KEY FK_E8ACBE764584665A');
        $this->addSql('ALTER TABLE products_tags DROP FOREIGN KEY FK_E3AB5A2C4584665A');
        $this->addSql('ALTER TABLE products_tags DROP FOREIGN KEY FK_E3AB5A2CBAD26311');
        $this->addSql('ALTER TABLE related_products DROP FOREIGN KEY FK_153914F75129EDC');
        $this->addSql('ALTER TABLE related_products DROP FOREIGN KEY FK_153914F7158E0B66');
        $this->addSql('ALTER TABLE sale_events_meta DROP FOREIGN KEY FK_CAEEC1226F830421');
        $this->addSql('ALTER TABLE supplier_meta DROP FOREIGN KEY FK_1AAAE2DC2ADD6D8C');
        $this->addSql('ALTER TABLE user_addresses DROP FOREIGN KEY FK_6F2AF8F2A76ED395');
        $this->addSql('ALTER TABLE user_addresses DROP FOREIGN KEY FK_6F2AF8F2131A4F72');
        $this->addSql('ALTER TABLE user_profiles DROP FOREIGN KEY FK_6BBD6130A76ED395');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E93D3D2749');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0A76ED395');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('ALTER TABLE wishlist DROP FOREIGN KEY FK_9CE12A31A76ED395');
        $this->addSql('ALTER TABLE wishlist DROP FOREIGN KEY FK_9CE12A314584665A');
        $this->addSql('DROP TABLE analytic_categories');
        $this->addSql('DROP TABLE analytics');
        $this->addSql('DROP TABLE attributes');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE communes');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE coupons');
        $this->addSql('DROP TABLE districts');
        $this->addSql('DROP TABLE `groups`');
        $this->addSql('DROP TABLE inventories');
        $this->addSql('DROP TABLE loyalties');
        $this->addSql('DROP TABLE loyalties_coupons');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE product_combo_items');
        $this->addSql('DROP TABLE product_reviews');
        $this->addSql('DROP TABLE product_variant_images');
        $this->addSql('DROP TABLE product_variants');
        $this->addSql('DROP TABLE product_variants_attributes');
        $this->addSql('DROP TABLE product_variants_inventories');
        $this->addSql('DROP TABLE product_variants_sale_events');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE products_categories');
        $this->addSql('DROP TABLE products_tags');
        $this->addSql('DROP TABLE provinces');
        $this->addSql('DROP TABLE related_products');
        $this->addSql('DROP TABLE sale_events');
        $this->addSql('DROP TABLE sale_events_meta');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE supplier_meta');
        $this->addSql('DROP TABLE suppliers');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE user_addresses');
        $this->addSql('DROP TABLE user_agents');
        $this->addSql('DROP TABLE user_profiles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_groups');
        $this->addSql('DROP TABLE wishlist');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
