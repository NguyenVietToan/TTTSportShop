<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;

class ContactController extends Controller
{
    public function getContact ()
    {
    	return view('user.pages.contact');
    }

    public function postContact (Request $request)
    {
    	$data = array(
			'email'          => $request->email,
			'subject'        => $request->subject,
			'contactMessage' => $request->message
    	);
    	Mail::send('user.email.sendContactMessage', $data, function($message) use ($data) {
    	    $message->from($data['email']);
    	    $message->to('nguyenviettoan161095@gmail.com');
    	    $message->subject($data['subject']);
    	});

    	return redirect()->route('getContact')->with(['flash_level' => 'success', 'flash_message' => 'Tin nhắn của bạn được gửi thành công !']);
    }
}
