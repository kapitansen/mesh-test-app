<?php

namespace Tests\Feature;

use App\Events\CreateRow;
use App\Imports\RowsImport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ImportFileTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->file = UploadedFile::fake()->create('myexcel.xlsx');
    }

    public function test_can_queue_import()
    {
        Excel::fake();

        Redis::spy();
        Event::fake();

        $response = $this->post('/', [
            'file' => $this->file,
        ]);

        $this->assertEquals('success', $response['upload']);

        Excel::assertQueued($response['path'], function(RowsImport $import) {
            $import->model([
                'name' => 'test',
                'date' => '44120',
                           ]);
            return true;
        });

        Event::assertDispatched(CreateRow::class);

        Redis::shouldHaveReceived('set');
    }

    public function tearDown(): void
    {
        Storage::fake('local');
        parent::tearDown();
    }

}
