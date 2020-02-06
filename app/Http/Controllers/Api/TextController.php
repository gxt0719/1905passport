<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TextController extends Controller
{
	public function text(Request $request){
		echo '<pre>';print_r($request->input());echo '</pre>';
	}
}