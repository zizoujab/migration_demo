<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180123162000 extends AbstractMigration
{
    use ContainerAwareTrait;

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD phone VARCHAR(255) NOT NULL, ADD street VARCHAR(255) NOT NULL, ADD zip_code VARCHAR(255) NOT NULL');
        $users = $this->connection->query("SELECT * FROM user");
        while ($user = $users->fetch()) {
            $contact = unserialize($user['contact']);
            $this->addSql(
                "UPDATE user SET phone= :phone, street= :street, zip_code= :zip_code WHERE id= :id",
                ["id" => $user['id'],
                    "phone" => $contact['phone'],
                    "street" => $contact['street'],
                    'zip_code' => $contact['zip_code']
                ]);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $users = $this->connection->query("SELECT * FROM user");

        while ($user = $users->fetch()) {
            $contact = serialize(['phone' => $user['phone'], 'street' => $user['street'], 'zip_code' => $user['zip_code']]);
            $this->addSql(
                "UPDATE user SET contact= :contact WHERE id= :id",
                ["id" => $user['id'],
                    "contact" => $contact,
                ]);
        }

        $this->addSql('ALTER TABLE user DROP phone, DROP street, DROP zip_code');
    }
}
