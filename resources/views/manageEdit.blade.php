@extends('layouts.app')


<style>

        
    .formDisplay{
        border:4px solid;
        border-radius:10px;
        border-color:rgb(170, 170, 170);
        padding:20px;
        width:500px;
        margin: auto;
    }

    .formDisplay .display_header, h2,label{
        font-family: 'Oswald', sans-serif;
    }
    .displayUserAdd{
        margin: auto;
    }

    .searchClass{
        height:100%;
  
    }   

    .createPosts{
        font-family: 'Oswald', sans-serif;
    }
        
    .display_header{
        /* rgb(120, 120, 120) */
        background-color:rgb(190, 190, 190);
        color:rgb(50, 50, 50);
        border-radius:4px;
        padding:20px;
        margin-bottom:2px;
    }

    .filterClass{
        background-color:rgb(120, 120, 120);
        padding:20px 0px 0px 0px;
        margin:0px 0px 4px 0px;
    }
    #searchName{
        text-align: center; 
    }

    #datefilter{
        text-align: center; 
    }

    table  thead > tr > th > a  {
        color: black;
        text-decoration:none;
    }

    table th > a > i{
        color: rgb(120, 120, 120);
    }

    .returnClass{
        color:red;
    }

    .returnClass:hover{
        color:#ff4c4c;
    }

    .undoSearchClass{
        height:100%;
  
    }  

    .undoSearchClass i {
        margin-top:4px;
    }

    .optionClass{
        text-align-last:center;
        font-family: "Lucida Console", "Courier New", monospace;
    }

</style>

@section('content')
<div class="container">
<div class="row">

    <div class="col-md-10">
        @if($mode ==1)
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                <!-- aria-selected="true" -->
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" >Manage</a>
                </li>
                @if($mode == 1)
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" >Posts</a>
                </li>
                @endif
            </ul>
         @else
        <br>
        <br>
        <div class="formDisplay">
            <div class="row " >

                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <h2 style="text-align:center">Add User</h2> 
                </div>
                <div class="col-lg-4"></div>

            </div>
         
            <form method="PUT" action="{{url('/manageStore')}}"  enctype="multipart/form-data">

                    @csrf


                    @if(session("response"))
                        <div class="alert alert-success">{{session("response")}}</div>
                    @endif

                    @if($mode==1)
                        <input type="number" name="id" value="{{$datas->id}}" hidden>
                    @endif

                    <label for="name">Name:</label>

                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="@if($mode==1){{$datas->name}}@endif" {{$disabled}} >
                    @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br>
                    <label for="level">Level:</label> 

                    <select class="form-control  @error('level') is-invalid @enderror" id="level" type="text" name="level" value="@if($mode==1){{$datas->level}}@endif" {{$disabled}}>
                        @if($mode==1)<option style="background-color:gray;color:white" value="{{$datas->level}}">{{ucfirst($datas->level)}}</option>@endif
                        <option value="cashier">Cashier</option>
                        <option value="manager">Manager</option>
                        <option value="junior accountant">Junior Accountant</option>
                    </select>

                    @error('level')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <br>
                    <button class="btn btn-success" {{$disabled}}>Submit</button>

                </form>
            </div>
         @endif
    </div>

        <div class="col-md-2">
            <a href="/manage" class="returnClass"><i class="fas fa-window-close fa-2x"></i></a>
        </div>   
    
</div>

</div>




<!-- Tab panes -->

@if($mode == 1)
<div class="tab-content">

    <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab">     
            
            <div class="container">      
            <br>  
                <div class="formDisplay">
              
                    <h2>Manage User</h2>
                    <br>

                    <form method="PUT" action="{{url('/manageUpdate')}}"  enctype="multipart/form-data">

                        @csrf

                    
                        @if(session("response"))
                            <div class="alert alert-success">{{session("response")}}</div>
                        @endif

                        @if($mode==1)
                            <input type="number" name="id" value="{{$datas->id}}" hidden>
                        @endif

                        <label for="name">Name:</label>

                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="@if($mode==1){{$datas->name}}@endif" {{$disabled}} >
                        @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <br>
                        <label for="level">Level:</label> 

                        <select class="form-control  @error('level') is-invalid @enderror" id="level" type="text" name="level" value="@if($mode==1){{$datas->level}}@endif" {{$disabled}}>
                            @if($mode==1)<option style="background-color:gray;color:white" value="{{$datas->level}}">{{ucfirst($datas->level)}}</option>@endif
                            <option value="cashier">Cashier</option>
                            <option value="manager">Manager</option>
                            <option value="junior accountant">Junior Accountant</option>
                        </select>

                        @error('level')
                                <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <br>
                        <button class="btn btn-success" {{$disabled}}>Submit</button>

                    </form>

                </div>
        </div>
       
  </div>


  <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <br>

                    
                    <div class="container">

                <div class="row display_header" >

                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-4">
                    <h2 style="text-align:center">POSTS</h2>
                    </div>
                    <div class="col-lg-4"></div>

                </div>

                <div class="row filterClass">
        
                    <div class="col-lg-10" >
                    
                        <form  action="{{url('/manageEdit/'.$datas->id)}}" method="GET" id="searchForm">
                        <!-- @csrf_field -->
                            @csrf
                            <input type="text" name="manageId" id="manageId" value="{{$datas->id}}" hidden>
                            <div class="row">

                                <div class="col-lg-3 optionClass">
                                    <select name="displayFilter" id="displayFilter" class="form-control">
                                        <option value="" disabled selected hidden>Select Filter</option>
                                        <option value="withTrashed">With Trashed</option>
                                        <option value="onlyTrashed">Only Trashed</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="height:100%;"><i  class="fas fa-calendar-plus fa-lg"></i></span>
                                        </div>
                                        <input type="text" autocomplete="off" name="datefilter" id="datefilter" class="form-control" value="" />
                                    </div>
                                    
                                </div>
                                <div class="col-lg-3">

                                    <div class="row">
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="searchName" name="searchName"  > 
                                        </div>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" id="search" name="search" value="1" hidden > 
                                            <button class="btn btn-outline-light searchClass" ><i class="fas fa-search fa-lg"></i></button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-3">
                                    @if($search == 1)<a href="/manageEdit/{{$datas->id}}" class="btn btn-outline-light undoSearchClass"><i class="fas fa-undo-alt fa-lg"></i></a> @endif
                                </div>
                                <!-- <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="height:100%;"><i  class="fas fa-calendar-plus fa-lg"></i></span>
                                        </div>
                                        <input type="text" autocomplete="off" name="datefilter" id="datefilter" class="form-control" value="" />
                                    </div>
                                </div> -->

                                <!-- <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="searchName" name="searchName"  > 
                                        </div>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" id="search" name="search" value="1" hidden > 
                                            <button class="btn btn-outline-light searchClass" ><i class="fas fa-search fa-lg"></i></button>
                                        </div>
                                    </div>
                    
                                </div> -->

                                <!-- <div class="col-md-2">@if($search == 1)<a href="/manageEdit/{{$datas->id}}" class="btn btn-outline-light undoSearchClass"><i class="fas fa-undo-alt fa-lg"></i></a> @endif</div> -->
                                
                            </div>  
                        </form>
                    </div>
                    <div class="col-lg-2" >
                    
                                @if(!$disabled)
                                        <a  class="btn btn-outline-light createPosts" href="/managePosts/{{$datas->id}}" >Create Post</a>
                                    @else
                                    <a style="float:right;" class="btn">Disabled</a>
                                    @endif
                    </div>
                    
                </div>
                    
                        <table class="table" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <a href="/manageEdit/{{$datas->id}}/{{$sort}}/id"># @if($sort == "ASC") <i class="fas fa-arrow-up fa-xs"></i> @else <i class="fas fa-arrow-down fa-xs"></i> @endif</a>
                                    </th>
                                    <th scope="col">
                                        <a href="/manageEdit/{{$datas->id}}/{{$sort}}/content">Content @if($sort == "ASC") <i class="fas fa-arrow-up fa-xs"></i> @else <i class="fas fa-arrow-down fa-xs"></i> @endif</a>
                                    </th>
                                    <th scope="col"><a href="/manageEdit/{{$datas->id}}/{{$sort}}/posted_by">Posted By @if($sort == "ASC") <i class="fas fa-arrow-up fa-xs"></i> @else <i class="fas fa-arrow-down fa-xs"></i> @endif</a></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                            
                                    <th scope="row">{{$post->id}}</th>
                                    <td >{{$post->content}}</td>
                                    <td>{{$post->management->name}}</td>
                                    <td>
                                        <a href="/managePostsEdit/{{$post->id}}" class="btn btn-warning" $disabled><i class="fas fa-edit"></i></a>
                                        
                                        @if(!$disabled)

                                            @if($post->deleted_at != NULL)
                                                <a href="/managePostsRestore/{{$post->id}}/{{$datas->id}}" class="btn btn-info" ><i class="fas fa-trash-restore"></i></a>
                                            @else
                                                <a href="/managePostsDestroy/{{$post->id}}/{{$datas->id}}" class="btn btn-danger" ><i class="fas fa-trash"></i></a>
                                            @endif
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            
                        <span>
                        {{$posts->links()}}
                        </span>

                    </div>
                 
      
    </div>

   

</div>
@endif


<script>



 

$(function() {
    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    
    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });


    $(document).ready(function() {
        
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        console.log(activeTab);
        if(activeTab){
            $('a[href="' + activeTab + '"]').tab('show');
        }
        
    });





});




</script>


@endsection
