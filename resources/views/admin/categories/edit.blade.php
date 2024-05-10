@extends('layouts.main')

@section('title')
    edit category
@endsection

@section('main-section')
    <div class="container mt-5">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        @if ($errors->all())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Errors!</h4>
                <ul>
                    @for ($i = 0; $i < count($errors->all()); $i++)
                        <li>{{ $errors->all()[$i] }}</li>
                    @endfor
                </ul>
            </div>
        @endif

        <h3 class="text-light mt-5">edit category</h3>
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('put')
            <div>
                <label for="name">name</label>
                <input type="text" id="name" value="{{ $category->name }}" name="name" class="form-control">
            </div>

            <input type="submit" value="update" class="btn btn-primary mt-3">
        </form>
    </div>
@endsection
