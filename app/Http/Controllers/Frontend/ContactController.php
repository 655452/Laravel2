<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Contact Us';
    }

    public function __invoke()
    {
        return view('frontend.contact', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [ 'name' => 'required', 'subject' => 'required', 'email' => 'required|email', 'message' => 'required' ]);

        try {
            Mail::send('emails.email',
                array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'user_message' => $request->get('message')
                ), function($message) use ($request)
                {
                    $message->from($request->get('email'));
                    $message->to(setting('site_email'), 'Admin');
                    $message->subject($request->get('subject'));
                });

        } catch (\Exception $exception) {
            dd($exception);
            return back()->with('error', 'Mail Not Sent');
        }

        return back()->with('success', 'Thanks for contacting us!');
    }
}
