<?php

namespace App\Notifications;

use Twilio\Rest\Client;

class NewAnswerSubmittedSms
{
    protected $account_sid;
    protected $auth_token;
    protected $number;
    protected $client;

    public $question;
    public $answer;
    public $answerUserName;

    /**
     * Create a new instance
     *
     * @return void
     */

    public function __construct($question, $answer, $name)
    {
        $this->account_sid = config('services.twilio.TWILIO_ACCOUNT_SID');
        $this->auth_token = config('services.twilio.TWILIO_AUTH_TOKEN');
        $this->number = config('services.twilio.TWILIO_NUMBER');

        $this->question = $question;
        $this->answer = $answer;
        $this->answerUserName = $name;

        $this->client = $this->setUp();
    }

    public function setUp()
    {
        $client = new Client($this->account_sid, $this->auth_token);

        return $client;
    }

    public function smsMessage($smsUserName)
    {
        return "Hi " . $smsUserName . ", A new answer was submitted to your question.  " .
                    $this->answerUserName . " just suggested: '" . $this->answer->content .
                    "'.  " . "View All Answers:  " . route('questions.show', $this->question->id) .
                    ".  Thank you for using Laravel Answers!";
    }

    public function send($number, $message)
    {
       $message = $this->client->messages->create($number, [
            'from' => $this->number,
            'body' => $message
        ]);

        return $message;
    }
}
