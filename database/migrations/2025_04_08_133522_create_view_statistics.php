<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW view_statistics AS
            SELECT
    categories.id,
    categories.name,
    COUNT(loans.id) AS loan_count
FROM
    categories
JOIN
    book_category ON categories.id = book_category.category_id
JOIN
    books ON book_category.book_id = books.id
JOIN
    loans ON books.id = loans.book_id
GROUP BY
    categories.id, categories.name
ORDER BY
    loan_count DESC");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_statistics");
    }
};
