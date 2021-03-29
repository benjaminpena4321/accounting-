<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Management;
use Illuminate\Pagination\Paginator;
use DB;

class AllPostsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function index(Request $request,$sort = "DESC", $column = "id")
    {
        Paginator::useBootstrap();
      $dateFrom = '';
      $dateTo = '';
      $where = "orWhere";
      $mode = 1;
      $disabled = "";
      $search = 0;
 
      if ($request->input('datefilter')){
          $date = explode(' - ',$request->input('datefilter'));
          $dateFrom = date('Y-m-d',strtotime($date[0]))." 00:00:00";
          $dateTo = date('Y-m-d',strtotime($date[1]))." 23:59:59";
          $where = 'where';
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
          ->where('management.deleted_at',NULL)
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

        if( ($request->input('search') && $request->input('searchName')!= NULL) || ($request->input('search') && $request->input('datefilter')!= NULL)){
            $search = 1;
        }

          return view('allPosts', 
          [
                  'mode' => $mode, 
                  'disabled'=> $disabled,
                  'datas'=> $datas,
                  'sort' => $sort,
                  'search'=> $search
                  // 'posts' => $management->posts()->withTrashed()->paginate(5)
              ]
          );

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
        $management  = Management::all();



        return view('createEditPost', [

                    'mode' => $mode,
                    'disabled' => $disabled,
                    'managements' => $management
                
                ]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $this->validate($request,[
            'content'=>'required',
            'manage_by'=>'required'
        ]);

    

        $posts = new Posts;
        
        $posts->content = $request->input('contents');
        $posts->posted_by = $request->input('manage_by');
        $posts->save();

        $response = 'Successfully Added';
        return redirect('createAllPost')->with('response',$response);

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
        // echo "<pre>";
        // echo $id;

        $mode = 1;
        // $management = Posts::where('id', $id)->first();

        $post = Posts::with('management')
                        ->where('id',$id)
                        ->first();
        $management = Management::all();

        return view('createEditPost', [
                    'datas' => $post,
                    'managements' => $management,
                    'mode' => $mode
                    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request,[
                        'content' => 'required',
                    ]);

        $updatePost = Posts::where('id',$request->input('postId'))
                    ->update([
                            'content' => $request->input('content'),
                            'posted_by' => $request->input('manage_by')
                    ]);
        
        $response = 'Successfully Updated';
        return redirect('allPostEdit/'.$request->input('postId'))->with('response',$response);
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Posts::destroy($id);

        return redirect('posts');
    }
}
