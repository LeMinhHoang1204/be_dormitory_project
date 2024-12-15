<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $path = $image->store('images', 'public');

        $invoice->update(['evidence_image' => $path]);

        return back()->with('success', 'Image uploaded successfully')->with('path', $path);
    }
}
