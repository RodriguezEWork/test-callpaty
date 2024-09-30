<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_get_categories(): void
    {
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
    }
}
