@extends('layouts.app')

@section('content')
<div class="container" style="text-align:center">
            <h2>Manage</h2>
    <br>
    <a href="/manage" class="btn btn-danger">Return</a>
    <form method="PUT" action="@if($mode == 0 ){{url('/manageStore')}}@else{{url('/manageUpdate')}}@endif"  enctype="multipart/form-data">

        @csrf

		@if(session("response"))
		<div class="alert alert-success">{{session("response")}}</div>
		@endif

        @if($mode==1)
		<input type="number" name="id" value="{{$datas->id}}" hidden>
		@endif


        <label for="name">Name:</label>

        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="@if($mode==1){{$datas->name}}@endif">
        <br>
        @error('name')
			    <div class="alert alert-danger">{{ $message }}</div>
		@enderror
         <br>
        <label for="level">Level:</label> 
        <input class="form-control  @error('level') is-invalid @enderror" id="level" type="text" name="level" value="@if($mode==1){{$datas->level}}@endif">

        @error('level')
			    <div class="alert alert-danger">{{ $message }}</div>
		@enderror


        <button class="btn btn-success">Submit</button>
    </form>
</div>
@endsection