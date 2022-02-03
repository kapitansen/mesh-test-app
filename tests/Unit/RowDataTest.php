<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Imports\RowsImport;

class RowDataTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_transform_date()
    {

        $import = new RowsImport('test_file.xslx');

        $this->assertEquals(
            date_format($import->transformDate('44120'), 'Y-m-d'),
            '2020-10-16',
        );
    }
}
