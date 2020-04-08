@extends('template')

@section('content')
    <div class="container">

        <!-- display the form, to submit an edit to update -->
        <form action="{{ route('questions.update', $question->id) }}" method="POST">
            @method('PATCH')
            {{ csrf_field() }}

            <h4>Edit Question:</h4>
            <h2><input type="text" class="form-control" value="{{ $question->title }}" name="title" /></h2>
            <textarea class="form-control" name="description" rows="4"> {{ $question->description }} </textarea>

            <button class="btn btn-primary">Update</button>
        </form>

    </div>
@endsection
