<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use App\Translate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TranslateController extends Controller
{
    use GeneralTrait;

    public function __construct(){

        $this->middleware( [
            // 'middleware'=> ['api', 'checkAdminToken'], // must be authenticated for add or update or delete
            'api', 
            'checkAdminToken'
        ],[
            //methods not need authontication as Admin api
            'except' => [
                'index', 
                'show',
                'search',
            ] 
        ]);        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->per_page ?? 10;
        $TermsList = Translate::paginate($per_page);

        return response()->json($TermsList, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!isset($request->term,$request->wEN,$request->wAR))
            return $this->returnError(
                'Fields Required'
            );
        $trans = new Translate(); 
        $trans->term = Str::upper($request->term);
        $trans->wEN = $request->wEN;
        $trans->wAR = $request->wAR;
        $trans->save();

        if($trans->save())
           return $this->returnData('term', $trans, 'Add Successful');
        else
            return $this->returnError('Dont Added.');   
    }

    public function store_list(Request $request)
    {
        // $trans = new Translate(); 
        $count = 0;
        foreach($request->list_terms as $item){
            $trans = new Translate(); 
            $trans->term = Str::upper($item['term']);
            $trans->wEN = $item['wEN'];
            $trans->wAR = $item['wAR'];
            $trans->save();
            $count++;
        }
     
        return $this->returnData(
            'terms', $count . ' terms added', 
            'Add terms Successful'
        );
        // else
        //     return response()->json($this->returnError('Dont Added.'));   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Translate  $translate
     * @return \Illuminate\Http\Response
     */
    public function show(Translate $translate)
    {
        // return $this->returnData('term', $translate, "get term successful");
        return response()
                ->json(
                $translate,
                200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Translate  $translate
     * @return \Illuminate\Http\Response
     */
    public function edit(Translate $translate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Translate  $translate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Translate $translate)
    {        
        $translate->term = Str::upper($request->term);
        $translate->wEN = $request->wEN;
        $translate->wAR = $request->wAR;
        $translate->updated_at = now();

        $updated = $translate->save();

        if($updated){
            return $this->returnData(
                'updated', $translate, 
                'Updated Successfuly'
            ); 
        }else{
            return $this->returnError('Updating Unsuccessfuly');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Translate  $translate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Translate $translate)
    {
        // $deleted = Translate::destroy($translate);
        $deleted = $translate->delete();
        if($deleted){
            return $this->returnData(
                'item', $translate, 
                'Deleted Successful'
            );
        }else{
            return $this->returnError('Deleting Unsuccessful');
        }
    }

    public function search(Request $request)
    {

        $term =  $request->term;
        $term = Str::slug($term, '_'); // to make the term searched to snake case 
        $term = strtoupper($term); // and make it 

        $results =  Translate::where('wEN', 'LIKE', '%'. $term . '%')
                                ->orWhere('term', 'LIKE', '%'. $term . '%')
                                ->orWhere('wAR', 'LIKE', '%'. $term . '%')
                                ->get();

        if($results->count() > 0){
            return $this->returnData(
                    'result', $results, 
                    'Success',
                    [
                        'count' =>  $results->count(),
                    ]
            );
        }else{
            return $this->returnData(
                'result', 'No results', 
                'Faild',
        );
        }                    
        
    }


}
