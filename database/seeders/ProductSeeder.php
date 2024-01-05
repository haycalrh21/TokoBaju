<?php

// database/seeders/ProductSeeder.php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('products')->insert([
                'namabarang' => $faker->word,
                'jenisbarang' => $faker->word,
                'brand' => $faker->word,
                'stok' => $faker->numberBetween(1, 100),
                'harga' => $faker->randomFloat(2, 10, 1000),
                'image' => $faker->imageUrl(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $productId = DB::getPdo()->lastInsertId();

            $sizes = ['S', 'M', 'L', 'XL'];

            foreach ($sizes as $size) {
                DB::table('product_sizes')->insert([
                    'product_id' => $productId,
                    'size' => $size,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
