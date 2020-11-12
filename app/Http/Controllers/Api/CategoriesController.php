<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Traits\GeneralTrait;

class CategoriesController extends Controller
{
    use GeneralTrait;

    public function index(){
        // $categories = DB::select('select * from categories');
        $categories = Category::all();

        return $this->returndata('categories',$categories,'All Categories');
    }
    public function getMainCat(){
        // $categories = DB::select('select * from categories');
        $categories = Category::select('id', 'name_' . app()->getLocale() . ' as name')->get();

        return response()->json($categories);
    }

    public function getCategoryByID(Request $request){

        $category = Category::find($request->id);

        if(!$category)
            return $this->returnError('E001', 'No Content');

        return $this->returnData('category', $category);
    }

    public function changeStatus(Request $request){

        //Validation
        Category::where('id', $request->id)->update(['active' => $request->active]);

        return $this->returnSuccessMessage('Updated Successful');
    }
}
