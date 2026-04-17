<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * Display a simple response for testing.
     *
     * @return \Illuminate\Http\Response|string
     */
    public function test()
    {
        // you can return a view or any content as needed
        $the_loai_sach = DB::table("dm_the_loai")->get();
      
        return view('test', ['the_loai_sach' => $the_loai_sach]);
    }
}
