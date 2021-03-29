@extends('layouts.app')


<style>
    center h1 {
        font-family: 'Oswald', sans-serif;

    }
</style>
@section('content')
<div class="container">
    <div class="row ">
        <div >
            <div class="card">
             
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <center> <h1> Dashboard </h1></center>
                   

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
