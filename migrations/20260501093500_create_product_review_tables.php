<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductReviewTables extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('product_review', [
            'id' => false,
            'primary_key' => ['product_id', 'user_id']
        ]);
        $table
            ->addColumn('product_id', 'string', ['limit' => 255])
            ->addColumn('user_id', 'string', ['limit' => 255])
            ->addColumn('user_display_name', 'string', ['limit' => 255])
            ->addColumn('rating', 'integer')
            ->addColumn('comment', 'string', ['limit' => 4096])
            ->addColumn('created_on', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
            ])
            ->create();

        $table = $this->table('product_review_count', [
            'id' => false,
            'primary_key' => ['product_id']
        ]);
        $table
            ->addColumn('product_id', 'string', ['limit' => 255])
            ->addColumn('rating_average', 'float')
            ->addColumn('rating_count', 'integer')
            ->addColumn('updated_on', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->create();
    }

    public function down(): void
    {
        $this->table('product_review')->drop()->save();
        $this->table('product_review_count')->drop()->save();
    }
}

