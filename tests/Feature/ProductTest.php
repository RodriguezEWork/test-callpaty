<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_product(): void
    {
        // Test validation errors
        $response = $this->post(route('products.store'), []);
        $response->assertSessionHasErrors(['name', 'description', 'price', 'category_id']);

        // Test successful creation
        $productData = Product::factory()->make()->toArray();

        $response = $this->post(route('products.store'), $productData);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Product created successfully']);

        $this->assertDatabaseHas('products', $productData);
    }

    public function test_show_returns_product(): void
    {
        $product = Product::factory()->create();
        
        $response = $this->get(route('products.show', $product));
        $response->assertStatus(200);

        $response->assertJson($product->toArray());
    }

    public function test_update_updates_product(): void
    {      
        // Test successful update
        $product = Product::factory()->create();
        $updatedProductData = Product::factory()->make()->toArray();

        $response = $this->put(route('products.update', $product), $updatedProductData);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Product updated successfully']);

        $this->assertDatabaseHas('products', $updatedProductData);
    }

    public function test_destroy_deletes_product(): void
    {
        $product = Product::factory()->create();
        
        $response = $this->delete(route('products.destroy', $product->id));
        
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Product deleted successfully']);
        
        $this->assertDatabaseMissing('products', $product->toArray());
    }
}
