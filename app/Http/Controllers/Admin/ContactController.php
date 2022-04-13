<?php

namespace App\Http\Controllers\admin;

use App\ContactUs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = ContactUs::orderBy('id', 'DESC')->get();
        
        return view('admin.contact.contact-requests', compact('contacts'));
    }
}
