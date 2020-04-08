@extends('template')

@section('content')
    <div class="container">
        <h1>Recent Questions</h1>
        <hr>

        @foreach ($questions as $question)
            <div class="shadow p-3 mb-5 bg-white rounded">
                <div class="well">
                    <div class="h3"> {{ $question->title }} </div>
                    <p>
                        {{ $question->description }}
                    </p>
                    <a href="{{ route('questions.show', $question->id) }}" class="btn btn-primary btn-sm">View Details</a>
                </div>
            </div>
        @endforeach

        {{ $questions->links() }}
    </div>
@endsection
