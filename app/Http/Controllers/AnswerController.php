<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Question;
use Illuminate\Support\Facades\Auth;

use App\Notifications\NewAnswerSubmittedEmail;
use App\Notifications\NewAnswerSubmittedSms;

class AnswerController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
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
            'content' => 'required|min:5',
            'question_id' => 'required|integer'
        ]);

        $answer = new Answer();
        $answer->content = $request->content;
        $answer->user()->associate(Auth::id());

        $question = Question::findOrFail($request->question_id);
        $question->answers()->save($answer);

        //Send an email to the User who asked the question
        $question->user->notify( new NewAnswerSubmittedEmail($question, $answer, Auth::user()->name));

        //Send an sms to the User who asked the question
        $twilio = new NewAnswerSubmittedSms($question, $answer, Auth::user()->name);
        $twilio->send($question->user->phoneNumber(), $twilio->smsMessage($question->user->name));

        return redirect()->route('questions.show', $question->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
