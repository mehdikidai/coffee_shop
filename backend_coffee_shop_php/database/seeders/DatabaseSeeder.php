<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enum\UserRole;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Receipt;
use App\Models\Setting;
use App\Models\Category;
use App\Models\StockLog;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use App\Models\IngredientProduct;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {



        // User::factory()->create([
        //     'name' => 'mehdi',
        //     'email' => 'mehdikidai@gmail.com',
        //     'role' => UserRole::ADMIN->value,
        //     'password' => Hash::make('12345678')
        // ]);

        //$email = app('admin_email') ?? 'admin@gmail.com';
        $email = 'admin@gmail.com';


        User::factory()->create([
            'name' => 'admin',
            'email' => $email,
            'role' => UserRole::ADMIN->value,
            'password' => Hash::make('12345678')
        ]);

        User::factory()->create([
            'name' => 'hiba',
            'email' => 'hiba@gmail.com',
            'role' => UserRole::BARISTA->value,
            'password' => Hash::make('12345678')
        ]);

        User::factory()->create([
            'name' => 'anas',
            'email' => 'anas@gmail.com',
            'role' => UserRole::BARISTA->value,
            'password' => Hash::make('12345678')
        ]);


        //User::factory(26)->create();


        foreach ($this->categories as $c) {
            Category::factory()->create(
                [
                    'id' => $c['id'],
                    'name' => $c['name'],
                    'icon' => $c['icon']
                ]
            );
        }


        foreach ($this->products as $p) {
            Product::factory()->create(
                [
                    'name' => $p['name'],
                    'price' => $p['price'],
                    'photo' => $p['photo'],
                    'category_id' => $p['categoryId']
                ]
            );
        }

        foreach ($this->ingredients as $in) {
            Ingredient::factory()->create([
                'name' => $in['name'],
                'unit' => $in['unit'],
                'unit_name' => $in['unit_name'],
                'stock' => $in['stock'],
                'price_per_unit' => $in['price_per_unit'],
                'stock_threshold' => $in['stock_threshold'],
            ]);
        }

        IngredientProduct::factory()->create([
            'product_id' => 1,
            'ingredient_id' => 1,
            'quantity' => 14,
        ]);

        IngredientProduct::factory()->create([
            'product_id' => 5,
            'ingredient_id' => 1,
            'quantity' => 14,
        ]);

        IngredientProduct::factory()->create([
            'product_id' => 5,
            'ingredient_id' => 2,
            'quantity' => 1,
        ]);

        Receipt::factory(5)->create();

        StockLog::factory(20)->create();

        Setting::updateOrCreate(['key' => 'site_name'], ['value' => 'bee coffee']);
        Setting::updateOrCreate(['key' => 'site_email'], ['value' => 'admin@beecoffee.com']);
        Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => 'off']);
        Setting::updateOrCreate(['key' => 'daily_expected_income'], ['value' => '400']);
        Setting::updateOrCreate(['key' => 'currency'], ['value' => 'DH']);
        Setting::updateOrCreate(['key' => 'pagination_limit'], ['value' => '12']);

        Review::factory(10)->create();


    }

    protected $categories = [
        [
            "id" => 1,
            "name" => "Expresso & Chocolat",
            "icon" => "uil:coffee"
        ],
        [
            "id" => 2,
            "name" => "Mojito Cocktails",
            "icon" => "uil:coffee"
        ],
        [
            "id" => 3,
            "name" => "Smoothies",
            "icon" => "uil:coffee"
        ],
        [
            "id" => 4,
            "name" => "Iced Coffee",
            "icon" => "uil:coffee"
        ],
        [
            "id" => 5,
            "name" => "Frappuccino & Milkshake",
            "icon" => "uil:coffee"
        ],
        [
            "id" => 6,
            "name" => "bouteilles d'eau",
            "icon" => "uil:coffee"
        ],
        [
            "id" => 7,
            "name" => "extra",
            "icon" => "uil:coffee"
        ]
    ];

    protected $products = [
        [
            "id" => 1,
            "name" => "Espresso",
            "price" => 6,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 2,
            "name" => "Espresso Arabica",
            "price" => 7,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 3,
            "name" => "Espresso Moka",
            "price" => 7,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 4,
            "name" => "Café Américano - Allongé",
            "price" => 8,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 5,
            "name" => "Café Crème",
            "price" => 8,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 6,
            "name" => "Café au Lait",
            "price" => 8,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 7,
            "name" => "Latte Machiatto",
            "price" => 10,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 8,
            "name" => "Cappuccino",
            "price" => 10,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 9,
            "name" => "Double Espresso",
            "price" => 12,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 10,
            "name" => "Chocolat chaud",
            "price" => 14,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 11,
            "name" => "Double Espresso Moka",
            "price" => 14,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 12,
            "name" => "Chocolat fondu",
            "price" => 15,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 1,
        ],
        [
            "id" => 13,
            "name" => "Mojito Classic",
            "price" => 14,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 2,
        ],
        [
            "id" => 14,
            "name" => "Mojito Passion Fruit",
            "price" => 15,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 2,
        ],
        [
            "id" => 15,
            "name" => "Mojito AVATAR",
            "price" => 16,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 2,
        ],
        [
            "id" => 16,
            "name" => "Mojito Fruit Rouge",
            "price" => 18,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 2,
        ],
        [
            "id" => 17,
            "name" => "Mojito Ananas",
            "price" => 17,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 2,
        ],
        [
            "id" => 18,
            "name" => "Banane",
            "price" => 13,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 3,
        ],
        [
            "id" => 19,
            "name" => "Fraise",
            "price" => 15,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 3,
        ],
        [
            "id" => 20,
            "name" => "Vitaminé",
            "price" => 16,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 3,
        ],
        [
            "id" => 21,
            "name" => "Mangue",
            "price" => 16,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 3,
        ],
        [
            "id" => 22,
            "name" => "Ananas",
            "price" => 16,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 3,
        ],
        [
            "id" => 23,
            "name" => "Tropical",
            "price" => 17,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 3,
        ],
        [
            "id" => 24,
            "name" => "Pina Colada",
            "price" => 18,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 3,
        ],
        [
            "id" => 25,
            "name" => "Almond Chocolate",
            "price" => 20,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 3,
        ],
        [
            "id" => 26,
            "name" => "Almond Joy Booster",
            "price" => 22,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 3,
        ],
        [
            "id" => 27,
            "name" => "Iced Caramel Macchiato",
            "price" => 14,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 4,
        ],
        [
            "id" => 28,
            "name" => "Iced Double Chocolat",
            "price" => 16,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 4,
        ],
        [
            "id" => 29,
            "name" => "Iced Cookie & Cream",
            "price" => 16,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 4,
        ],
        [
            "id" => 30,
            "name" => "Iced Vanilla Sweet Cream",
            "price" => 17,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 4,
        ],
        [
            "id" => 31,
            "name" => "Iced Spanish Latte",
            "price" => 18,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 4,
        ],
        [
            "id" => 32,
            "name" => "Iced Coffee Oreo",
            "price" => 18,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 4,
        ],
        [
            "id" => 33,
            "name" => "Frappuccino Chocolat",
            "price" => 19,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 5,
        ],
        [
            "id" => 34,
            "name" => "Frappuccino Vanilla",
            "price" => 19,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 5,
        ],
        [
            "id" => 35,
            "name" => "Frappuccino Fraise",
            "price" => 19,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 5,
        ],
        [
            "id" => 36,
            "name" => "Frappuccino Oreo - KitKat - Cookies",
            "price" => 25,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 5,
        ],
        [
            "id" => 37,
            "name" => "Frappuccino Cheesecake",
            "price" => 27,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 5,
        ],
        [
            "id" => 38,
            "name" => "Frappuccino Framboise",
            "price" => 22,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/cup-coffee.jpg",
            "categoryId" => 5,
        ],
        [
            "id" => 39,
            "name" => "Bouteille d'eau - 1.5 L",
            "price" => 5,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/weather.jpg",
            "categoryId" => 6,
        ],
        [
            "id" => 40,
            "name" => "Bouteille d'eau - 0.5 L",
            "price" => 3,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/weather.jpg",
            "categoryId" => 6,
        ],
        [
            "id" => 41,
            "name" => "Bouteille d'eau - 33 CL",
            "price" => 2,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/weather.jpg",
            "categoryId" => 6,
        ],
        [
            "id" => 45,
            "name" => "verre d'eau",
            "price" => 1,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/weather.jpg",
            "categoryId" => 6,
        ],
        [
            "id" => 42,
            "name" => "aromes",
            "price" => 1,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/honey.jpg",
            "categoryId" => 7,
        ],
        [
            "id" => 43,
            "name" => "Miel single",
            "price" => 2,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/honey.jpg",
            "categoryId" => 7,
        ],
        [
            "id" => 44,
            "name" => "Miel double",
            "price" => 3,
            "photo" => "https://zaz-fashion.com/wp-content/uploads/2025/05/honey.jpg",
            "categoryId" => 7,
        ],
    ];

    protected $ingredients = [
        [
            "name" => "coffee",
            "unit" => "g",
            "unit_name" => "gram",
            "stock" => 5000,
            "price_per_unit" => 0.05,
            "stock_threshold" => 500,
        ],
        [
            "name" => "milk",
            "unit" => "l",
            "unit_name" => "liter",
            "stock" => 40,
            "price_per_unit" => 1.20,
            "stock_threshold" => 5,
        ],
        [
            "name" => "honey",
            "unit" => "g",
            "unit_name" => "gram",
            "stock" => 3000,
            "price_per_unit" => 0.10,
            "stock_threshold" => 300,
        ],
        [
            "name" => "water bottle 1.5",
            "unit" => "bottle",
            "unit_name" => "bottle",
            "stock" => 100,
            "price_per_unit" => 5,
            "stock_threshold" => 20,
        ],
        [
            "name" => "water bottle 0.5",
            "unit" => "bottle",
            "unit_name" => "bottle",
            "stock" => 100,
            "price_per_unit" => 3,
            "stock_threshold" => 20,
        ],
        [
            "name" => "water bottle 0.33",
            "unit" => "bottle",
            "unit_name" => "bottle",
            "stock" => 100,
            "price_per_unit" => 2,
            "stock_threshold" => 20,
        ],
    ];
}
