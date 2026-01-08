<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    /* ========================
       GALLERY LIST
    ========================= */
    public function index()
    {
        $gallery = DB::table('gallery')
            ->select('id', 'image', 'video', 'type', 'created_at')
            ->orderBy('id', 'desc')
            ->get();

        return view('gallery.index', compact('gallery'));
    }

    /* ========================
       UPDATE GALLERY
    ========================= */
  public function update(Request $request, $id)
{
    $data = [
        'type' => $request->type,
        'updated_at' => now(),
    ];

    if ($request->hasFile('image')) {
        $img = $request->file('image');
        $name = time() . '_img.' . $img->getClientOriginalExtension();
        $img->move(public_path('uploads/gallery'), $name);

        // FULL URL
        $data['image'] = url('uploads/gallery/' . $name);
    }

    if ($request->hasFile('video')) {
        $vid = $request->file('video');
        $name = time() . '_vid.' . $vid->getClientOriginalExtension();
        $vid->move(public_path('uploads/gallery'), $name);

        // FULL URL
        $data['video'] = url('uploads/gallery/' . $name);
    }

    DB::table('gallery')->where('id', $id)->update($data);

    return back()->with('success', 'Gallery updated successfully');
}

    
    
    
    /* ========================
   STORE GALLERY
========================= */
public function store(Request $request)
{
    $data = [
        'type' => $request->type,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    if ($request->hasFile('image')) {
        $img = $request->file('image');
        $name = time() . '_img.' . $img->getClientOriginalExtension();
        $img->move(public_path('uploads/gallery'), $name);

        // FULL URL
        $data['image'] = url('uploads/gallery/' . $name);
    }

    if ($request->hasFile('video')) {
        $vid = $request->file('video');
        $name = time() . '_vid.' . $vid->getClientOriginalExtension();
        $vid->move(public_path('uploads/gallery'), $name);

        // FULL URL
        $data['video'] = url('uploads/gallery/' . $name);
    }

    DB::table('gallery')->insert($data);

    return back()->with('success', 'Gallery added successfully');
}



public function delete($id)
{
    DB::table('gallery')->where('id', $id)->delete();
    return back()->with('success','Gallery deleted successfully');
}

}
