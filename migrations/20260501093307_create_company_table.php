<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCompanyTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('company');
        $table
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('productsApiUrl', 'string', ['limit' => 255])
            ->addColumn('enabled', 'boolean', ['default' => 1])
            ->create();

        // Seed test data with unique productsApiUrl
        $this->table('company')->insert([
            [
                'name' => 'Dummy Company 1',
                'productsApiUrl' => 'http://nginx:80/api/test/products?company=1',
                'enabled' => 1
            ],
            [
                'name' => 'Dummy Company 2',
                'productsApiUrl' => 'http://nginx:80/api/test/products?company=2',
                'enabled' => 1
            ]
        ])->saveData();
    }

    public function down(): void
    {
        $this->table('company')->drop()->save();
    }
}
