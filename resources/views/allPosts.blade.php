@extends('layouts.app')


<style>
    
    .display_header{
        /* rgb(120, 120, 120) */
        background-color:rgb(190, 190, 190);
        color:rgb(50, 50, 50);
        border-radius:4px;
        padding:20px;
        margin-bottom:2px;
    }

    input[type="text"]:focus{
        /* color: rgb(80, 80, 80); */
        box-shadow: 0 0 8px 0 rgb(170, 170, 170);
        /* background-color:white; */
    } 

    h2{
        font-family: 'Oswald', sans-serif;
    }

    .filterClass{
        background-color:rgb(120, 120, 120);
        padding:20px 0px 0px 0px;
        margin:0px 0px 4px 0px;
    }

    .searchClass{
        height:100%;
  
    }   

    .addClass{
        font-family: 'Oswald', sans-serif;
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
    <div class="row display_header" >

        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <h2 style="text-align:center">All Posts</h2> 
        </div>
        <div class="col-lg-4"></div>
        
    </div>
    <div class="row filterClass">
     
        <div class="col-lg-10" >

            <form action="{{url('/posts')}}" method="GET">
            
                <div class="row">

                    <div class="col-lg-3 optionClass">
                            <!-- <select name="displayFilter" id="displayFilter" class="form-control">
                                <option value="" disabled selected hidden>Select Filter</option>
                                <option value="withTrashed">With Trashed</option>
                                <option value="onlyTrashed">Only Trashed</option>
                            </select> -->
                    </div>
                    <div class="col-lg-3 ">

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="height:100%;"><i  class="fas fa-calendar-plus fa-lg"></i></span>
                            </div>
                            <input type="text" autocomplete="off" name="datefilter" id="datefilter" class="form-control" value="" />
                        </div>

                    </div>
                    <div class="col-lg-3 ">
                        <div class="row">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="searchName" name="searchName" > 
                            </div>
                            <div class="col-sm-2">
                                <input type="text" name="search" id="search" value="1" hidden>
                                <button class="btn btn-outline-light searchClass" ><i class="fas fa-search fa-lg"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                    @if($search == 1)
                            <a href="/posts" class="btn btn-outline-light undoSearchClass">
                                <i class="fas fa-undo-alt fa-lg"></i>
                            </a> 
                        @endif
                    </div>
                    
                </div>

            </form>
        </div>
        <div class="col-lg-2" >
        
            <a  class="btn btn-outline-light addClass" href="/createAllPost">Create Post</a>
        </div>
       
    </div>
   
    <table class=" table table-striped"  style="text-align: center;">
        <thead>
            <tr>
            <div class="row">
                <th scope="col">
                        <a href="/posts/{{$sort}}/id"># @if($sort == "ASC") <i class="fas fa-arrow-up fa-xs"></i> @else <i class="fas fa-arrow-down fa-xs"></i> @endif</a>
                </th>
            </div>
                <th scope="col">
                    <a href="/posts/{{$sort}}/name">Content @if($sort == "ASC") <i class="fas fa-arrow-up fa-xs"></i> @else <i class="fas fa-arrow-down fa-xs"></i> @endif </a> 
                </th>
                <th scope="col">
                    <a href="/posts/{{$sort}}/level">Posted By @if($sort == "ASC") <i class="fas fa-arrow-up fa-xs"></i> @else <i class="fas fa-arrow-down fa-xs"></i> @endif </a> 
                </th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->content}}</td>
                    <td>{{$data->management->name}}</td>
                    <td>

                        <a href="/allPostEdit/{{$data->id}}"  class="btn btn-warning"><i class="fas fa-edit"></i></a>
                         @if($data->deleted_at != NULL)
                         <a href="/allPostRestore/{{$data->id}}" class="btn btn-info"><i class="fas fa-trash-restore"></i></a>
                        @else 
                         <a href="/allPostDestroy/{{$data->id}}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        @endif 

                    </td>
                </tr>
            @endforeach
        </tbody>
   </table>

    <span>
    {{$datas->links()}}
    </span>


<script>
 

    $(function() {

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



    });

</script>
   


@endsection
