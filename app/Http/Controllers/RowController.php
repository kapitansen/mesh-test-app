<?php

namespace App\Http\Controllers;

use App\Models\Row;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Row[]|\Illuminate\Database\Eloquent\Collection|Response
     */
    public function index()
    {
        return Row::all()->groupBy('date');
    }
}
