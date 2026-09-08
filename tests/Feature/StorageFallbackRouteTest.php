<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageFallbackRouteTest extends TestCase
{
    public function test_fallback_serves_existing_file_from_public_disk(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('events/banners/test_banner.jpg', 'fake-image-binary-data');

        $response = $this->get('/storage/events/banners/test_banner.jpg');

        $response->assertStatus(200);
        $this->assertEquals('fake-image-binary-data', $response->streamedContent());
    }

    public function test_fallback_returns_404_for_missing_file(): void
    {
        Storage::fake('public');

        $response = $this->get('/storage/events/banners/non_existent.jpg');

        $response->assertStatus(404);
    }

    public function test_fallback_blocks_path_traversal(): void
    {
        $response = $this->get('/storage/../../.env');

        $response->assertStatus(404);
    }
}
