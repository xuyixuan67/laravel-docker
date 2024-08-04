<?php

namespace Tests\Unit;

use Tests\TestCase;

class OrderApiTest extends TestCase
{
    public function test_valid_order_request()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 1000,
            'currency' => 'TWD'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Order created successfully!',
                'data' => [
                    'id' => 'A0000001',
                    'name' => 'Melody Holiday Inn',
                    'address' => [
                        'city' => 'taipei-city',
                        'district' => 'da-an-district',
                        'street' => 'fuxing-south-road'
                    ],
                    'price' => 1000,
                    'currency' => 'TWD'
                ]
            ]);
    }

    public function test_invalid_order_request_name_not_capitalized()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'melody Holiday Inn', // Not capitalized
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 1000,
            'currency' => 'TWD'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_invalid_order_request_name_contains_non_english_letters()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inñ', // Contains non-English letter
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 1000,
            'currency' => 'TWD'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_price_transformation_when_currency_is_usd()
    {
        $response = $this->postJson('/api/orders', [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road'
            ],
            'price' => 100,
            'currency' => 'USD'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Order created successfully!',
                'data' => [
                    'id' => 'A0000001',
                    'name' => 'Melody Holiday Inn',
                    'address' => [
                        'city' => 'taipei-city',
                        'district' => 'da-an-district',
                        'street' => 'fuxing-south-road'
                    ],
                    'price' => 3100, // 100 * 31
                    'currency' => 'TWD'
                ]
            ]);
    }
}
