@extends('layouts.main')

@section('title')
    create new blog
@endsection

@section('main-section')
    <div class="container mt-5">

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

        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" class="text-light">
            @csrf
            <div>
                <label for="title">title</label>
                <input type="text" id="title" value="{{ old('title') }}" name="title" class="form-control">
            </div>
            <div>
                <label for="excerpt">excerpt</label>
                <input type="text" id="excerpt" value="{{ old('excerpt') }}" name="excerpt" class="form-control">
            </div>
            <div>
                <label for="categories">categories</label>
                <select name="category" id="categories" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="thumbnail">thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" class="form-control">
            </div>
            <div>
                <label for="blog-body">blog body</label>
                <textarea name="blog-body" id="blog-body tiny" cols="30" rows="10" class="form-control">{{ old('blog-body') }}</textarea>
            </div>

            <div>
                <label for="publish">publish</label>
                <input type="checkbox" id="publish" name="publish">
            </div>

            <input type="submit" class="btn btn-primary mt-3">
        </form>
    </div>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                "See docs to implement AI Assistant")),
        });
    </script>
@endsection
