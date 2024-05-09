@extends('layouts.main')

@section('title')
    create new category
@endsection

@section('main-section')
    <div class="container">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        <h3 class="text-light mt-5">create new category</h3>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div>
                <label for="name">name</label>
                <input type="text" id="name" name="name" class="form-control">
            </div>

            <input type="submit" class="btn btn-primary mt-3">
        </form>
    </div>
@endsection
