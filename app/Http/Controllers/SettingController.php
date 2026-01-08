<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    
     /* ========================
       SOCIAL LINKS LIST
    ========================= */
    public function socialLinks()
    {
        // usually single row hoti hai
        $social = DB::table('social_links')->first();

        return view('social_links', compact('social'));
    }

    /* ========================
       UPDATE SOCIAL LINKS
    ========================= */
    public function updateSocialLinks(Request $request, $id)
    {
        DB::table('social_links')
            ->where('id', $id)
            ->update([
                'facebook' => $request->facebook,
                'instagram'=> $request->instagram,
            ]);

        return back()->with('success', 'Social links updated successfully');
    }
    
    // 🔹 Slider List
    public function sliders()
    {
        $sliders = DB::table('sliders')
            ->select('id', 'title', 'image', 'status', 'createdAt')
            ->orderBy('id', 'desc')
            ->get();

        return view('sliders.index', compact('sliders'));
    }

    // 🔹 Update Slider
    public function updateSlider(Request $request, $id)
    {
        $data = [
            'title'  => $request->title,
            'status' => $request->status,
        ];

        // image update (optional)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sliders'), $name);
            $data['image'] = 'uploads/sliders/' . $name;
        }

        DB::table('sliders')->where('id', $id)->update($data);

        return back()->with('success', 'Slider updated successfully');
    }
    
    
    /* ========================
       CONTACT DETAILS LIST
    ========================= */
    public function contactDetails()
    {
        $contacts = DB::table('contact_details')
            ->select('id', 'address', 'phone', 'email', 'created_at')
            ->orderBy('id', 'desc')
            ->get();

        return view('contact_details', compact('contacts'));
    }

    /* ========================
       UPDATE CONTACT DETAILS
    ========================= */
    public function updateContactDetails(Request $request, $id)
    {
        DB::table('contact_details')
            ->where('id', $id)
            ->update([
                'address' => $request->address,
                'phone'   => $request->phone,
                'email'   => $request->email,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Contact details updated successfully');
    }
    
    
}
