@extends('template')

@section('content')
    <div class="container">
        <div class="shadow p-3 mb-5 bg-white rounded">
            <h1>{{ $question->title }}</h1>
            <p class="lead">
                {{ $question->description }}
            </p>
            <p>
                Submitted by: {{ $question->user->name }},  {{ $question->created_at->diffForHumans() }}
            </p>
            <div class="text-right">
                <a href="{{ $question->edit }}" class="btn btn-primary" >Edit</a>
            </div>

        </div>


        <!-- display all of the answers for this question -->
        @if ($question->answers->count() > 0)

            @foreach ($question->answers as $answer)
                <div class="card">
                    <div class="card-body">
                        <p>
                            {{ $answer->content }}
                        </p>
                        <div class="text-right">
                            Submitted by:  {{ $answer->user->name }}, {{ $answer->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <br>
            @endforeach
        @else
            <p>
                There are no answers for this question yet.  Please consider submitting one below.
            </p>
        @endif
        <hr/>

        <!-- display the form, to submit a new answer -->
        <form action="{{ route('answers.store') }}" method="POST">
            {{ csrf_field() }}

            <h4>Submit your Own Answers:</h4>
            <textarea class="form-control" name="content" rows="4"></textarea>
            <input type="hidden" value="{{ $question->id }}" name="question_id" />
            <button class="btn btn-primary">Submit Answer</button>
        </form>

    </div>
@endsection
