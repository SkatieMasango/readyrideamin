<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\PaymentGateway;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $paymentGateways = PaymentGateway::paginate(perPage: 10, page: 1);
        return view('payment-gateways.index',compact('paymentGateways'));
    }
     public function create(): View
    {
        return view('payment-gateways.create');
    }

     public function store(Request $request)
    {
        $validations = [
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|in:active,in_active',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'secret_key' => 'required',
            'public_key' => 'required',
        ];

        if($request->type == 'cash'){
            $validations['secret_key'] = 'nullable';
            $validations['public_key'] = 'nullable';
        }

        $request->validate($validations);

        $file = $request->file('image');
        $filePath = $file->store('payment_gateways', 'public');

        $media = new Media([
            'name' => $file->getClientOriginalName(),
            'path' => $filePath,
            'type' => 'payment_gateway',
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        $config = json_encode([
            'public_key' => $request->public_key,
            'secret_key' => $request->secret_key,
        ]);

        $paymentGateway = PaymentGateway::create([
            'title' => $request->title,
            'type' => $request->type,
            'status' => $request->status,
            'config' => $config ?? null,
        ]);

        $paymentGateway->gatewayPicture()->save($media);

        return redirect()->route('management.payment-gateways.index')->with('success', 'Payment Gateway created successfully.');

    }

    public function edit($id): View
    {
        $paymentGateway = PaymentGateway::find($id);
        return view('payment-gateways.edit',compact('paymentGateway'));
    }

     public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'status' => 'required|in:active,in_active',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'secret_key' => 'required',
            'public_key' => 'required',
        ]);
        $paymentGateway = PaymentGateway::findOrFail($id);
        $media = $paymentGateway->gatewayPicture()->first();

        if($request->hasFile('image') == true){
            if ($media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            }
            $file = $request->file('image');
            $filePath = $file->store('payment_gateways', 'public');
            $media = new Media([
                'name' => $file->getClientOriginalName(),
                'path' => $filePath,
                'type' => 'profile_picture',
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
            $paymentGateway->gatewayPicture()->save($media);
            }

            $config = json_encode([
                'public_key' => $request->public_key,
                'secret_key' => $request->secret_key,
            ]);

            $paymentGateway->update([
                'title' => $request->title,
                'type' => $request->type,
                'status' => $request->status,
                'config' => $config ?? null,

            ]);
        return redirect()->route('management.payment-gateways.index')->with('success', 'Payment Gateway updated successfully.');
    }

    public function destroy($id)
    {
        $paymentGateway = PaymentGateway::findOrFail($id);
        $paymentGateway->delete();
        return redirect()->back()->with('success', 'Gateway deleted successfully!');
    }

}
