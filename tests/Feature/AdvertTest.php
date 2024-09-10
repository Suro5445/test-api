<?php

namespace Tests\Feature;

use App\Models\Advert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdvertTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_paginated_list_of_adverts()
    {

        Advert::factory()->count(5)->create();

        $response = $this->getJson('/api/adverts?page=1');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'price',
                        'main_image',
                    ],
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links' => [
                        '*' => [
                            'url',
                            'label',
                            'active',
                        ],
                    ],
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
            ]);


        $advert = Advert::first();
        $response->assertJsonFragment([
            'id' => $advert->id,
            'title' => $advert->title,
            'price' => (string)$advert->price,
            'main_image' => $advert->images[0] ?? null,
        ]);
    }

    /** @test */
    public function it_returns_single_advert_with_required_fields()
    {
        $advert = Advert::factory()->create([
            'images' => json_encode([
                'https://graphicsfamily.com/wp-content/uploads/edd/2022/11/Professional-Advertising-Poster-Design-for-Tea-Product-scaled.jpg'
            ]),
        ]);


        $response = $this->getJson('/api/adverts/' . $advert->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $advert->id,
                    'title' => $advert->title,
                    'price' => (string)$advert->price,
                    'main_image' => $advert->images[0] ?? null,
                ],
            ]);
    }

    /** @test */
    public function it_creates_an_advert_successfully()
    {
        $data = [
            'title' => 'New Advert',
            'description' => 'Description for the new advert',
            'images' => [
                'https://example.com/image1.jpg',
                'https://example.com/image2.jpg',
            ],
            'price' => 99.99,
        ];

        $response = $this->postJson('/api/adverts', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Advert created successfully',
            ])
            ->assertJsonStructure([
                'id',
                'message',
            ]);


        $this->assertDatabaseHas('adverts', [
            'title' => $data['title'],
            'price' => $data['price'],
        ]);
    }



}
