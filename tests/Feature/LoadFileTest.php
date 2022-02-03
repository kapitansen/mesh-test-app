<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;

class LoadFileTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_wrong_format_validation(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 120);

        $response = $this->post('/', [
            'file' => $file,
        ]);

        $response->assertInvalid(['file']);
    }

    public function test_xlsx_format_validation(): void
    {
        $file = UploadedFile::fake()->create('document.xlsx', 120);

        $response = $this->post('/', [
            'file' => $file,
        ]);

        $response->assertValid(['file']);
    }


    public function test_upload_file(): void
    {
        Excel::shouldReceive('import')->once()->andReturnNull();

        $file = UploadedFile::fake()->create('document.xlsx', 120);

        $response = $this->post('/', [
            'file' => $file,
        ]);

        $response->assertViewHas('path');
        $response->assertViewHas('filename');
        $this->assertEquals('success', $response['upload']);

        Storage::disk('local')->assertExists('rows_import/' . $response['filename']);
    }

    public function tearDown(): void
    {
        Storage::fake('local');
        parent::tearDown();
    }

}
