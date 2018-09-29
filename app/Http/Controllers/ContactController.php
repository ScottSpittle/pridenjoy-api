<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequest;
use App\Mail\ContactResponseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct()
    {

    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required|string',
            'phone' => 'required|string',
            'message' => 'required|string',
            'method' => 'required|in:EMAIL,SNAILMAIL,TELEPHONE'
        ]);

        $input = $request->input();

        try {
            Mail::to('spittlescott+admin@gmail.com')
                ->queue(new ContactResponseRequest($input['name'], $input['email'], $input['phone'], $input['method'], $input['message']));

            Mail::to($input['email'])
                ->queue(new ContactRequest($input['name']));
        } catch (\Exception $e) {
            return response('Failed to send email', 500);
        }

        return response(null, 204);
    }
}
