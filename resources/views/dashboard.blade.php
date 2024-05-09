@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('main-section')
    <div class="container mt-5">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col">thumbnail</th>
                    <th scope="col">title</th>
                    <th scope="col">excerpt</th>
                    <th scope="col">published</th>
                    <th scope="col">update</th>
                    <th scope="col">delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <th><img src='{{ asset("front-end/blog_images/$blog->thumbnail") }}' width="50px" alt="">
                        </th>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->excerpt }}</td>
                        <td>
                            @if ($blog->published == 1)
                                YES
                            @else
                                NO
                            @endif
                        </td>
                        <td><a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-primary">update</a></td>
                        <td>
                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="submit" class="btn btn-danger" value="delete">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container mt-5">
        {{ $blogs->links() }}
    </div>
@endsection
