<?php

namespace App\Imports;

use App\Events\CreateRow;
use App\Models\Row;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterImport;

class RowsImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithEvents
{

    use RemembersRowNumber, RegistersEventListeners;

    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        Redis::set($this->fileName, $this->getRowNumber());

        $rowData = [
           'id'     => $this->getRowNumber() - 1, // https://github.com/SpartnerNL/Laravel-Excel/issues/3400
           'name'    => $row['name'],
           'date' => date_format($this->transformDate($row['date']), 'Y-m-d')
        ];

        CreateRow::dispatch($rowData, $this->fileName);

        return new Row($rowData);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @param $value
     * @param $format
     * @return \Carbon\Carbon|false
     */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    /**
     * @param AfterImport $event
     * @return void
     */
    public static function afterImport(AfterImport $event): void
    {
        Redis::del($event->getConcernable()->fileName);
    }

}
