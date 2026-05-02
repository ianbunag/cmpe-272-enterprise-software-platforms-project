<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateVisitTrackingTables extends AbstractMigration
{
    public function up(): void
    {
        // Table for tracking visits per user per product without a default id
        $userVisitCount = $this->table('user_visit_count', [
            'id' => false,
            'primary_key' => ['user_id', 'product_id']
        ]);
        $userVisitCount
            ->addColumn('product_id', 'string', ['limit' => 255])
            ->addColumn('user_id', 'string', ['limit' => 255])
            ->addColumn('visit_count', 'integer', ['default' => 0])
            ->addColumn('updated_on', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->create();

        // Table for tracking total visits per product without a default id
        $visitCount = $this->table('visit_count', [
            'id' => false,
            'primary_key' => ['product_id']
        ]);
        $visitCount
            ->addColumn('product_id', 'string', ['limit' => 255])
            ->addColumn('visit_count', 'integer', ['default' => 0])
            ->addColumn('updated_on', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->create();
    }

    public function down(): void
    {
        $this->table('user_visit_count')->drop()->save();
        $this->table('visit_count')->drop()->save();
    }
}
