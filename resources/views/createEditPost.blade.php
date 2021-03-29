@extends('layouts.app')

<style>
   .formDisplay{
        border:4px solid;
        border-radius:10px;
        border-color:rgb(170, 170, 170);
        padding:20px;
        width:500px;
        /* margin: auto; */
        margin-left:350px;
    }

    .formDisplay .display_header, h2,label{
        font-family: 'Oswald', sans-serif;
    }

    .returnClass{
        color:red;
    }

    .returnClass:hover{
        color:#ff4c4c;
    }


</style>

@section('content')
<div class="container" >

    <div class="row">
        <div class="col-lg-10">
            <div class="formDisplay"> 
                <div class="row " >
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-6">
                        <h2>Manage Post</h2> 
                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
                <br>
            
                <form method="PUT" action="@if($mode==0){{url('/storeAllPost')}}@else{{url('/updateAllPost')}}@endif"  enctype="multipart/form-data">
                    @csrf

                    @if(session("response"))
                    <div class="alert alert-success">{{session("response")}}</div>
                    @endif

                    <!-- posts id for edit -->
                    <!-- if edit == 1 -->

                    @if($mode == 1 )
                        <input type="text" value="{{$datas->id}}" name="postId" id="postId" hidden>
                    @endif

                    @error('content')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="content">Content:</label>
                    <textarea  class="form-control @error('content') is-invalid @enderror" id="content" name="content" value="@if($mode==1){{$datas->content}}@endif" cols="30" rows="10">@if($mode==1){{$datas->content}}@endif</textarea>
                    <br>
              
                    @error('manage_by')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="manage_by">Manage By:</label>
                        <select name="manage_by" id="manage_by" class="form-control  @error('manage_by') is-invalid @enderror">
                          
                            @if($mode==1)
                            <option value="{{$datas->management->id}}" selected hidden>{{$datas->management->name}}</option>
                            @else
                                <option value="" disabled selected hidden>Select Manage By....</option>
                            @endif
                            @foreach ($managements as $management)
                            <option value="{{$management->id}}">{{$management->name}}</option>
                            @endforeach
                            
                        </select>
             
                    <br>

                            <button class="btn btn-success">Submit</button>


                </form>
            </div>
        </div>
        <div class="col-lg-2">
            <a href="/posts" class="returnClass"><i class="fas fa-window-close fa-2x"></i></a>
        </div>

    </div>
    
</div>

@endsection('content')