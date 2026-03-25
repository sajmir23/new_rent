<?php

namespace App\Http\Controllers;

use App\Enums\UserTypesEnum;
use App\Models\ContactForm;
use App\Models\User;
use App\Notifications\ContactFormNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use function Laravel\Prompts\error;


class ContactFormController extends Controller
{

    /**
     * Display all contact form submissions.
     */

    public function index()
    {
        $contacts = ContactForm::all();
        return view('admin.contact_form.index')->with([
            'contacts' =>$contacts,
        ]);
    }

    /**
     * Store a new contact form submission.
     */

    public function store(Request $request)
    {
        $valitedData = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:contact_form,email',
            'phone_number' => 'required|string|max:20',
            'message'      => 'required|string',

        ]);

        $existing_email=ContactForm::where('email',$valitedData['email'])->first();

        if($existing_email)
        {
            return response()->json([
                'message' => 'Email already exist',
                'existing_email' => $existing_email,
            ],422);
        }
        $contact=ContactForm::create($valitedData);

        $user=User::where('user_type',UserTypesEnum::SYSTEM_ADMIN)->first();

       Notification::send($user, new ContactFormNotification($contact));

        return response()->json([
            'message'=>'Your message has been sent. Thank you!',
            'contact'=>$contact
        ]);
    }
}
