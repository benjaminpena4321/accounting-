<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Management;
use App\Models\Posts;
use Illuminate\Pagination\Paginator;
use DB;
use App\Http\Requests\ManagerStoreRequest;
use DateTime;


// echo app()->make('sample');
class ManageController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');


        $sample = app()->make('Hello');
        dd($sample);

    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $sort = 'DESC', $column = 'id')
    {
        $dateFrom = '';
        $dateTo = '';
        $where = "orWhere";
        $search = 0;
        $displayFilter = $request->input('displayFilter');
        Paginator::useBootstrap();

       if($displayFilter == ''){
        $displayFilter = 'noTrash';
       }
        
        if ($request->input('datefilter')){
            $date = explode(' - ',$request->input('datefilter'));
            $dateFrom = date('Y-m-d',strtotime($date[0]))." 00:00:00";
            $dateTo = date('Y-m-d',strtotime($date[1]))." 23:59:59";
            $where = 'where';
        }
        
        $seachThis = $request->input('searchName');
        $datas = Management::whereBetween('created_at',[$dateFrom,$dateTo])
                  ->$where(function ($query) use ($seachThis) {
                    $query->where('name','like',"%".$seachThis."%")
                    ->orWhere('level','like',"%".$seachThis."%")
                        ->orWhere('id','like',"%".$seachThis."%");
                } )
            ->when($displayFilter == 'onlyTrashed', function ($q) {
                    return $q->onlyTrashed();
                })
            ->when($displayFilter == 'withTrashed', function ($q) {
                    return $q->withTrashed();
                })
            ->when($displayFilter == 'noTrash', function ($q) {
                // notrash return nothing
            })
            ->orderBy($column,$sort)
            ->paginate(5)
            ->withQueryString();

        switch ($sort) {
            case "ASC":
                $sort = "DESC";
              break;
            case "DESC":
                $sort = "ASC";
              break;
          }
        
        if( ($request->input('search') && $request->input('searchName')!= NULL) || ($request->input('search') && $request->input('datefilter')!= NULL) ||  ($request->input('search') && $displayFilter!= NULL)){
            $search = 1;
        }

        return view('management', ['datas' => $datas, 'sort'=>$sort, 'search'=> $search]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        $disabled = '';
        $mode = 0;

        return view('manageEdit', ['mode' => $mode,'disabled'=>$disabled]);
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

        return redirect('manageAdd')->with('response', $response);
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
    public function edit(Request $request, $id, $sort = "DESC", $column = "id")
    {
    //   DB::connection()->enableQueryLog();
      Paginator::useBootstrap();
      $dateFrom = '';
      $dateTo = '';
      $where = "orWhere";
      $mode = 1;
      $disabled = "";
      $displayFilter = $request->input('displayFilter');
      $management = Management::where('id', $id)->first();
      $search = 0;
      if(!$management){
          $disabled = "disabled";
          $management = Management::onlyTrashed()
          ->where('id', $id)
          ->first();
      }

      if ($request->input('datefilter')){
          $date = explode(' - ',$request->input('datefilter'));
          $dateFrom = date('Y-m-d',strtotime($date[0]))." 00:00:00";
          $dateTo = date('Y-m-d',strtotime($date[1]))." 23:59:59";
          $where = 'where';
      }

      if($displayFilter == ''){
        $displayFilter = 'noTrash';
       }
      
      $searchThis = $request->input('searchName');
      $datas = Posts::leftJoin('management', 'posts.posted_by', '=', 'management.id')
              ->select('posts.id as id','management.name as name','posts.posted_by as posted_by','posts.content as content','posts.deleted_at as deleted_at')
              ->whereBetween('posts.created_at',[$dateFrom,$dateTo])
              ->$where(function ($query) use ($searchThis) {
                  $query->where('posts.content','like',"%".$searchThis."%")
                  ->orWhere('management.name','like',"%".$searchThis."%")
                      ->orWhere('posts.id','like',"%".$searchThis."%");
              } )
              ->when($displayFilter == 'onlyTrashed', function ($q) {
                return $q->onlyTrashed();
            })
            ->when($displayFilter == 'withTrashed', function ($q) {
                    return $q->withTrashed();
                })
            ->when($displayFilter == 'noTrash', function ($q) {
                // notrash return nothing
            })
          ->where('management.id',$id)
          ->orderBy($column,$sort)
          ->paginate(5)
          ->withQueryString();

        switch ($sort) {
            case "ASC":
                $sort = "DESC";
              break;
            case "DESC":
                $sort = "ASC";
              break;
          }

        if( ($request->input('search') && $request->input('searchName')!= NULL) || ($request->input('search') && $request->input('datefilter')!= NULL) || ($request->input('search') && $displayFilter != NULL) ){
            $search = 1;
        }

          return view('manageEdit', 
          [
                  'datas' => $management, 
                  'mode' => $mode, 
                  'disabled'=> $disabled,
                  'posts'=> $datas,
                  'sort' => $sort,
                  'search'=> $search
                  // 'posts' => $management->posts()->withTrashed()->paginate(5)
              ]
          );
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
            ->where('id', $request->input('id'))
            ->update(array(
                'name' => $request->input('name'),
                'level' => $request->input('level')
            ));

        $response = 'Updated';

        return redirect('manage')->with('response', $response);
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

    public function restore($id)
    {
        Management::withTrashed()
        ->where('id', $id)
        ->restore();

        return redirect('manage');
    }
}
