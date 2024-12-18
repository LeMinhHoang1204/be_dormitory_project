<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Residence;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request, $id)
    {
//        echo($request->image); exit;
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $path = $image->store('images', 'public');

        return $path;
    }

    public function saveToInvoice(Request $request, $id)
    {
        $path = $this->upload($request, $id);

        $invoice = Invoice::findOrFail($id);

        $invoice->update(['evidence_image' => $path]);
    }

    public function saveToRequest(Request $requestApi, $id)
    {
        $path = $this->upload($requestApi, $id);

        $request = \App\Models\Request::findOrFail($id);

        $request->update(['evidence_image' => $path]);
    }

    public function saveToResidence(Request $request, $id)
    {
        $path = $this->upload($request, $id);

        $residence = Residence::findOrFail($id);

        $residence->update(['note' => $path]);

        return back()->with('success', 'Image uploaded successfully')->with('path', $path);
    }
}
