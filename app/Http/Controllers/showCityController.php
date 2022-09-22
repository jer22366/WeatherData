<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class showCityController extends Controller
{
    public function show(Request $request)
    {
        $input = $request->input('number');
        return $input;
    }
}

?>