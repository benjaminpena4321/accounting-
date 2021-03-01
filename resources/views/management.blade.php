@extends('layouts.app')

@section('content')
<div class="container">
    <div style="text-align:center">
        <h2>Management</h2> <div style="float:right"><a class="btn btn-primary" href="/manageAdd">Add User</a></div>
    </div>
    <br>
   
    <table class="table" style="text-align: center;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Level</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->level}}</td>
                    <td>
                        <a href="/manageEdit/{{$data->id}}"  class="btn btn-danger">Edit</a>
                        <a href="/manageRemove/{{$data->id}}" class="btn btn-warning">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
   </table>
</div>

@endsection