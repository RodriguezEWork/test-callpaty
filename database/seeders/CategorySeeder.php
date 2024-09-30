<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electrónicos', 'Ropa', 'Hogar', 'Jardín', 'Deportes',
            'Juguetes', 'Libros', 'Música', 'Películas', 'Alimentos',
            'Bebidas', 'Muebles', 'Automóviles', 'Herramientas', 'Belleza',
            'Salud', 'Joyería', 'Mascotas', 'Bebés', 'Arte',
            'Fotografía', 'Viajes', 'Instrumentos musicales', 'Oficina', 'Cocina',
            'Baño', 'Iluminación', 'Calzado', 'Relojes', 'Bolsos',
            'Accesorios', 'Fitness', 'Camping', 'Pesca', 'Caza',
            'Bricolaje', 'Jardinería', 'Electrodomésticos', 'Computadoras', 'Smartphones',
            'Tablets', 'Consolas de videojuegos', 'Cámaras', 'Audio', 'Televisores',
            'Impresoras', 'Redes', 'Almacenamiento', 'Software', 'Cursos online'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
