<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Go to the model and get a group of records
        $questions = Question::orderBy('id', 'desc')->paginate(5);

        // Returns the view, and pass in the group of records to loop through
        return view('questions.index')->with('questions', $questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255'
        ]);
        // process data and submit
        $question = new Question();
        $question->title = $request->title;
        $question->description = $request->description;
        $question->user()->associate(Auth::id());

        // if successful we want to redirect
        if ($question->save()) {
            return redirect()->route('questions.show', $question->id);
        } else {
            return redirect()->route('questions.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Use the model to get 1 record from the database
        $question = Question::findOrFail($id);

        // Show the view and pass the record to the view
        return view('questions.show')->with('question', $question);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);

        return view('questions.edit')->with('question', $question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required',
        ]);

        $question = Question::findOrFail($id);
        $question->title =  $request->get('title');
        $question->description = $request->get('description');

        // Update the question
        if ($question->save( )) {
            return redirect()->route('questions.show', $question->id)->with('success', 'Contact updated!');
        } else {
            return redirect()->route('questions.edit', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
