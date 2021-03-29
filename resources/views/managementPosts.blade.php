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
            
                <form method="PUT" action="@if($mode==0){{url('/createPost')}}@else{{url('/updatePost')}}@endif"  enctype="multipart/form-data">
                    @csrf

                    @if(session("response"))
                    <div class="alert alert-success">{{session("response")}}</div>
                    @endif

                    <!-- posts id for edit -->
                    <!-- if edit == 1 -->
                
                    @if($mode == 1)
                    <input type="number" id="id" name="id" value="{{$id}}" hidden>
                    @else
                    <!-- management id for create -->
                <input type="number" id="posted_by" name="posted_by" value="{{$id}}" hidden>
                @endif

                    <label for="name">Content:</label>
                

                    @if($deleted_management)
                        <div style="border:1px solid black;">
                            {{$datas->content}}
                        </div>
                    @elseif($mode == 1)
                        @if($datas->deleted_at)
                        <div style="border:1px solid black;">
                            {{$datas->content}}
                        </div>
                        @else
                            <textarea  class="form-control @error('content') is-invalid @enderror" id="content" name="content" value="@if($mode==1){{$datas->content}}@endif" cols="30" rows="10">@if($mode==1){{$datas->content}}@endif</textarea>
                        @endif
                    @else
                        <textarea  class="form-control @error('content') is-invalid @enderror" id="content" name="content" value="@if($mode==1){{$datas->content}}@endif" cols="30" rows="10">@if($mode==1){{$datas->content}}@endif</textarea>
                    @endif
                    <br>
                    @error('content')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br>

                    @if(!$deleted_management)
                        @if($mode == 1)
                            @if($datas->deleted_at)
                            @else
                            <button class="btn btn-success">Submit</button>
                            @endif
                        @else
                            <button class="btn btn-success">Submit</button>
                        @endif

                    @else

                    @endif
                </form>
            </div>
        </div>
        <div class="col-lg-2">
            <a href="@if($mode==0)/manageEdit/{{$id}}@else/manageEdit/{{$posted_by}}@endif" class="returnClass"><i class="fas fa-window-close fa-2x"></i></a>
        </div>

    </div>
    
</div>

@endsection('content')