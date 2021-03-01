<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Management;
use DB;
use App\Http\Requests\ManagerStoreRequest;

class ManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = DB::table('management')->get();
        return view('management',['datas' => $datas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
   

        $mode = 0;

        return view('manageEdit',['mode'=>$mode]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
      
        $this->validate($request, [
            'name' => 'required|max:50',
            'level' => 'required|max:50'
        ]);

        $management = new Management;
        $management->name =  $request->input('name');
        $management->level =  $request->input('level');
 

        $management->save();
         $response = 'Successfully Added';

         return redirect('manageAdd')->with('response',$response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mode = 1;
        $data = Management::where('id', $id)->first();
        
        return view('manageEdit',['datas'=>$data, 'mode'=>$mode]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManagerStoreRequest $request)
    {
       
        DB::table('management')
        ->where('id', $request->input('id') )
        ->update(array(
                    'name' => $request->input('name'),
                    'level' => $request->input('level')
                ));

         $response = 'Updated';

         return redirect('manage')->with('response',$response);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Management::destroy($id);

        return redirect('manage');
    }
}
