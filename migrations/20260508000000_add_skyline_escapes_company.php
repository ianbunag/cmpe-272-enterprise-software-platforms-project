<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddSkylineEscapesCompany extends AbstractMigration
{
    public function up(): void
    {
        $this->table('company')->insert([
            [
                'name'           => 'Skyline Escapes',
                'productsApiUrl' => 'http://nginx:80/api/skyline-escapes/products',
                'enabled'        => 1,
            ],
        ])->saveData();
    }

    public function down(): void
    {
        $this->execute("DELETE FROM company WHERE name = 'Skyline Escapes'");
    }
}
