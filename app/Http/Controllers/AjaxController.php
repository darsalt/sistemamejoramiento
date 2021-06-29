<?php
  
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


   
class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequest()
    {
        return view('ajaxRequest');
    }
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequestPost(Request $request)
    {
    Log::info('Name entered is in fact Tim'); // This does get printed


        $input = $request->all();
        \Log::info($input);
   
        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }
   
}