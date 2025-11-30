<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SmsConfig;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SmsConfigController extends Controller
{
     public function index()
    {
        $smsConfigs = SmsConfig::paginate(perPage: 10, page: 1);

        return view('sms-configs.index',compact('smsConfigs'));
    }
     public function create(): View
    {
        return view('sms-configs.create');
    }

     public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required',
        ]);

        if($request->type === 'twilio'){
            $request->validate([
            'twilio_sid' => 'required',
            'twilio_token' => 'required',
            'twilio_from' => 'required',
        ]);

        $config = json_encode([
            'twilio_sid' => $request->twilio_sid,
            'twilio_token' => $request->twilio_token,
            'twilio_from' => $request->twilio_from,
        ]);

        }else if($request->type === 'telesign'){
             $request->validate([
            'customer_id' => 'required',
            'api_key' => 'required',

        ]);

        $config = json_encode([
            'customer_id' => $request->customer_id,
            'api_key' => $request->api_key,
        ]);
        }
        else if($request->type === 'nexmo'){
             $request->validate([
            'nexmo_key' => 'required',
            'nexmo_secret' => 'required',
            'nexmo_from' => 'required',
        ]);

        $config = json_encode([
            'nexmo_key' => $request->nexmo_key,
            'nexmo_secret' => $request->nexmo_secret,
            'nexmo_from' => $request->nexmo_from,
        ]);
        }
        else if($request->type === 'messagebird'){
             $request->validate([
            'm_api_key' => 'required',
            'from' => 'required',
        ]);

        $config = json_encode([
            'm_api_key' => $request->m_api_key,
            'from' => $request->from,
        ]);
        }

        SmsConfig::create([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
            'data' => $config ?? null,
        ]);

        return redirect()->route('sms-configs.index')->with('success', 'Sms Provider created successfully.');

    }

    public function edit($id): View
    {

        $smsConfig = SmsConfig::find($id);
        return view('sms-configs.edit',compact('smsConfig'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required',
        ]);

        if($request->type === 'twilio'){
            $request->validate([
            'twilio_sid' => 'required',
            'twilio_token' => 'required',
            'twilio_from' => 'required',
        ]);

        $config = json_encode([
            'twilio_sid' => $request->twilio_sid,
            'twilio_token' => $request->twilio_token,
            'twilio_from' => $request->twilio_from,
        ]);

        }else if($request->type === 'telesign'){
             $request->validate([
            'customer_id' => 'required',
            'api_key' => 'required',

        ]);

        $config = json_encode([
            'customer_id' => $request->customer_id,
            'api_key' => $request->api_key,
        ]);
        }
        else if($request->type === 'nexmo'){
             $request->validate([
            'nexmo_key' => 'required',
            'nexmo_secret' => 'required',
            'nexmo_from' => 'required',
        ]);

        $config = json_encode([
            'nexmo_key' => $request->nexmo_key,
            'nexmo_secret' => $request->nexmo_secret,
            'nexmo_from' => $request->nexmo_from,
        ]);
        }
        else if($request->type === 'messagebird'){
             $request->validate([
            'm_api_key' => 'required',
            'from' => 'required',
        ]);

        $config = json_encode([
            'm_api_key' => $request->m_api_key,
            'from' => $request->from,
        ]);
        }
        $SmsConfig = SmsConfig::findOrFail($id);
        $SmsConfig->update([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
            'data' => $config ?? null,
        ]);
        return redirect()->back()->with('success', 'Payment Gateway updated successfully.');
    }
}
