<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinksControllerTest extends TestCase
{
    /**
     * @dataProvider linksToCreate
     *
     * @return void
     */
    public function test_store($link, $responseCode)
    {
        $response = $this->postJson('/links', $link);
        $response->assertStatus($responseCode);
    }

    /**
     * @return void
     */
    public function test_list()
    {
        $response = $this->get('/links');
        $response->assertStatus(200);
    }

    /**
     * @return array
     */
    public function linksToCreate(): array
    {
        $links = file_get_contents(__DIR__ . '/data/links.json');
        return json_decode($links, true);
    }
}
