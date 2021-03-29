<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Models\Posts;
use App\Models\Management;
use Illuminate\Pagination\Paginator;
use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Http\Controllers\Redirect;

class PostsController extends Controller
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
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $mode = 0;

        return view('managementPosts',[
                'mode'=>$mode, 
                'id'=>$id , 
                'deleted_management'=>''
            ]);

    }

    // public function search(Request $request)
    //     {
            // DB::connection()->enableQueryLog();
            // Paginator::useBootstrap();
            // $dateFrom = '';
            // $dateTo = '';
            // $where = "orWhere";
            // $mode = 1;
            // $disabled = "";
            // $sort = "DESC";
            // $management = Management::where('id', $request->input('manageId'))->first();

            // if(!$management){
            //     $disabled = "disabled";
            //     $management = Management::onlyTrashed()
            //     ->where('id', $request->input('manageId'))
            //     ->first();
            // }

            // if ($request->input('datefilter')){
            //     $date = explode(' - ',$request->input('datefilter'));
            //     $dateFrom = date('Y-m-d',strtotime($date[0]))." 00:00:00";
            //     $dateTo = date('Y-m-d',strtotime($date[1]))." 23:59:59";
            //     $where = 'where';
            // }
            
            // $searchThis = $request->input('searchName');
            // $datas = Posts::leftJoin('management', 'posts.posted_by', '=', 'management.id')
            //         ->select('posts.id as id','management.name as name','posts.posted_by as posted_by','posts.content as content')
            //         ->whereBetween('posts.created_at',[$dateFrom,$dateTo])
            //         ->$where(function ($query) use ($searchThis) {
            //             $query->where('posts.content','like',"%".$searchThis."%")
            //             ->orWhere('management.name','like',"%".$searchThis."%")
            //                 ->orWhere('posts.id','like',"%".$searchThis."%");
            //         } )
            //     ->where('management.id',$request->input('manageId'))
            //     ->paginate(5);
                
            // $datas = Posts::whereHas('management', function($query) use ($searchThis){
            //     $query->orWhere('management.name','like',"%".$searchThis."%")
                            
            // })
            // ->paginate(5);
                    
            // $queries = DB::getQueryLog();
            // echo "<pre>";
            // print_r($datas);
            // dd($queries);
            // die();
             
            // $searchThis = $request->input('searchName');
            // Paginator::useBootstrap();
            // $datas = Posts::whereBetween('created_at',[$dateFrom,$dateTo])
            //         ->$where(function ($query) use ($searchThis) {
            //             $query->where('content','like',"%".$searchThis."%")
            //             ->orWhere('posted_by','like',"%".$searchThis."%")
            //                 ->orWhere('id','like',"%".$searchThis."%");
            //         } )
            //     ->paginate(5);
            // echo "<pre>";
            // print_r($datas);
            // die();
            // return view('manageEdit', 
            // [
            //         'datas' => $management, 
            //         'mode' => $mode, 
            //         'disabled'=> $disabled,
            //         'posts'=> $datas,
            //         'sort' => $sort,
            //         'search'=> 1
            //         // 'posts' => $management->posts()->withTrashed()->paginate(5)
            //     ]
            // );
        // }




    public function store(Request $request)
    {

        $this->validate($request, [
            'content' => 'required'
        ]);

        $post = new Posts;
        $post->content =  $request->input('content');
        $post->posted_by =  $request->input('posted_by');
 
        $post->save();
        $response = 'Successfully Added';
          
        return redirect('managePosts/'.$request->input('posted_by'))->with('response',$response);

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
        $posts = Posts::where('id', $id)->withTrashed()->first();
        $management = $posts->management()->first();

        return view('managementPosts',[
            'mode'=>$mode,
            'datas'=>$posts, 
            'id'=>$posts->id , 
            'posted_by'=>$posts->posted_by,
            'deleted_management'=>$management->deleted_at
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

        DB::table('posts')
        ->where('id', $request->input('id'))
        ->update(array(
            'content' => $request->input('content')
        ));

        $response = 'Updated';
       
        // return redirect('manage')->with('response', $response);
        return redirect('managePostsEdit/'.$request->input('id'))->with('response', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pid , $id)
    {
        // echo $pid;
        // echo "        ";
        // echo $id;
        // die();
       Posts::destroy($pid);
       return redirect()->route('manageEdit', ['id' => $id]);
    }

    public function restore($pid , $id)
    {
        Posts::withTrashed()
        ->where('id', $pid)
        ->restore();
       return redirect()->route('manageEdit', ['id' => $id]);
    }

}
