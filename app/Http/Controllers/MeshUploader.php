<?php

namespace App\Http\Controllers;

use App\Imports\RowsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class MeshUploader extends Controller
{
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|max:50000|mimes:xls,xlsx',
        ]);

        if ($validated) {

            $fileName = time()
                . '_' .
                strtolower(Str::random(3))
                . '.' .
                $request->file('file')->getClientOriginalExtension();

            $path = Storage::disk('local')->putFileAs('rows_import', $request->file('file'), $fileName);

            Excel::import(new RowsImport($fileName), $path);

            return view('welcome', [
                'upload' => 'success',
                'path' => $path,
                'filename' => $fileName
            ]);
        }

    }

}
