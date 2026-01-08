<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    
    public function storeHall(Request $request)
    {
    // 1️⃣ INSERT PROPERTY (HALL)
    $propertyId = DB::table('properties')->insertGetId([
        'type'        => 'hall',
        'name'        => $request->name,
        'description' => $request->description,
        'min_guests'  => $request->min_guests,
        'max_guests'  => $request->max_guests,
        'base_price'  => $request->base_price,
        'status'      => $request->status,
        'created_at'  => now(),
        'updated_at'  => now(),
    ]);

    /* =========================
       2️⃣ UPLOAD IMAGES
    ========================= */
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $name = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/properties'), $name);

            DB::table('property_images')->insert([
                'property_id' => $propertyId,
                'image'       => 'uploads/properties/'.$name,
            ]);
        }
    }

    /* =========================
       3️⃣ SAVE FACILITIES
    ========================= */
    if ($request->has('facilities')) {
        foreach ($request->facilities as $facilityId) {
            DB::table('property_facilities')->insert([
                'property_id' => $propertyId,
                'facility_id' => $facilityId,
            ]);
        }
    }

    return back()->with('success', 'Hall added successfully');
}
    /* ===========================
       HALLS LIST WITH FULL DETAIL
    ============================ */
    public function halls()
    {
    $properties = DB::table('properties as p')
        ->leftJoin('property_images as pi', 'pi.property_id', '=', 'p.id')
        ->leftJoin('property_ratings as pr', 'pr.property_id', '=', 'p.id')
        ->where('p.type', 'hall')
        ->select(
            'p.id',
            'p.name',
            'p.description',
            'p.min_guests',
            'p.max_guests',
            'p.base_price',
            'p.status',
            DB::raw('GROUP_CONCAT(DISTINCT pi.image) as images'),
            DB::raw('ROUND(AVG(pr.rating),1) as avg_rating'),
            DB::raw('COUNT(pr.id) as total_ratings')
        )
        ->groupBy(
            'p.id','p.name','p.description',
            'p.min_guests','p.max_guests',
            'p.base_price','p.status'
        )
        ->orderBy('p.id','desc')
        ->get();

    // facilities
    foreach ($properties as $property) {
        $property->facilities = DB::table('property_facilities as pf')
            ->join('facilities as f', 'f.id','=','pf.facility_id')
            ->where('pf.property_id',$property->id)
            ->pluck('f.name')
            ->toArray();
    }

    return view('properties.halls', compact('properties'));
}

    /* ===========================
       UPDATE HALL
    ============================ */
    public function updateHall(Request $request, $id)
    {
        DB::table('properties')
            ->where('id', $id)
            ->update([
                'name'        => $request->name,
                'min_guests'  => $request->min_guests,
                'max_guests'  => $request->max_guests,
                'base_price'  => $request->base_price,
                'rating'      => $request->rating,
                'status'      => $request->status,
                'is_featured' => $request->is_featured,
                'updated_at'  => now()
            ]);

        return back()->with('success', 'Hall updated successfully');
    }
    

/* ===========================
   LAWNS LIST WITH RATING
=========================== */
public function lawns()
{
    $properties = DB::table('properties as p')
        ->leftJoin('property_images as pi', 'pi.property_id', '=', 'p.id')
        ->leftJoin('property_ratings as pr', 'pr.property_id', '=', 'p.id')
        ->where('p.type', 'lawn')
        ->select(
            'p.id',
            'p.name',
            'p.description',
            'p.min_guests',
            'p.max_guests',
            'p.base_price',
            'p.status',
            'p.is_featured',
            DB::raw('GROUP_CONCAT(DISTINCT pi.image) as images'),
            DB::raw('ROUND(AVG(pr.rating),1) as avg_rating'),
            DB::raw('COUNT(pr.id) as total_ratings')
        )
        ->groupBy(
            'p.id','p.name','p.description',
            'p.min_guests','p.max_guests',
            'p.base_price','p.status','p.is_featured'
        )
        ->orderBy('p.id','desc')
        ->get();

    foreach ($properties as $property) {
        $property->facilities = DB::table('property_facilities as pf')
            ->join('facilities as f', 'f.id','=','pf.facility_id')
            ->where('pf.property_id',$property->id)
            ->pluck('f.name')
            ->toArray();
    }

    return view('properties.lawns', compact('properties'));
}


public function storeLawn(Request $request)
{
    $propertyId = DB::table('properties')->insertGetId([
        'type'        => 'lawn',
        'name'        => $request->name,
        'description' => $request->description,
        'min_guests'  => $request->min_guests,
        'max_guests'  => $request->max_guests,
        'base_price'  => $request->base_price,
        'status'      => $request->status,
        'is_featured' => $request->is_featured ?? 0,
        'created_at'  => now(),
        'updated_at'  => now(),
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $name = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/properties'), $name);

            DB::table('property_images')->insert([
                'property_id' => $propertyId,
                'image'       => 'uploads/properties/'.$name,
            ]);
        }
    }

    if ($request->has('facilities')) {
        foreach ($request->facilities as $facilityId) {
            DB::table('property_facilities')->insert([
                'property_id' => $propertyId,
                'facility_id' => $facilityId,
            ]);
        }
    }

    return back()->with('success','Lawn added successfully');
}


/* ===========================
   UPDATE LAWN
=========================== */
public function updateLawn(Request $request, $id)
{
    DB::table('properties')
        ->where('id', $id)
        ->update([
            'name'        => $request->name,
            'min_guests'  => $request->min_guests,
            'max_guests'  => $request->max_guests,
            'base_price'  => $request->base_price,
            'rating'      => $request->rating,
            'status'      => $request->status,
            'is_featured' => $request->is_featured,
            'updated_at'  => now()
        ]);

    return back()->with('success', 'Lawn updated successfully');
}


/* ===========================
   ROOMS LIST WITH FULL DETAIL
=========================== */
/* ===========================
   ROOMS LIST WITH RATING
=========================== */
public function rooms()
{
    $properties = DB::table('properties as p')
        ->leftJoin('property_images as pi', 'pi.property_id', '=', 'p.id')
        ->leftJoin('property_ratings as pr', 'pr.property_id', '=', 'p.id')
        ->where('p.type', 'room')
        ->select(
            'p.id',
            'p.name',
            'p.description',
            'p.min_guests',
            'p.max_guests',
            'p.base_price',
            'p.status',
            'p.is_featured',
            DB::raw('GROUP_CONCAT(DISTINCT pi.image) as images'),
            DB::raw('ROUND(AVG(pr.rating),1) as avg_rating'),
            DB::raw('COUNT(pr.id) as total_ratings')
        )
        ->groupBy(
            'p.id','p.name','p.description',
            'p.min_guests','p.max_guests',
            'p.base_price','p.status','p.is_featured'
        )
        ->orderBy('p.id','desc')
        ->get();

    foreach ($properties as $property) {
        $property->facilities = DB::table('property_facilities as pf')
            ->join('facilities as f', 'f.id','=','pf.facility_id')
            ->where('pf.property_id',$property->id)
            ->pluck('f.name')
            ->toArray();
    }

    return view('properties.rooms', compact('properties'));
}


public function storeRoom(Request $request)
{
    $propertyId = DB::table('properties')->insertGetId([
        'type'        => 'room',
        'name'        => $request->name,
        'description' => $request->description,
        'min_guests'  => $request->min_guests,
        'max_guests'  => $request->max_guests,
        'base_price'  => $request->base_price,
        'status'      => $request->status,
        'is_featured' => $request->is_featured ?? 0,
        'created_at'  => now(),
        'updated_at'  => now(),
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $name = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/properties'), $name);

            DB::table('property_images')->insert([
                'property_id' => $propertyId,
                'image'       => 'uploads/properties/'.$name,
            ]);
        }
    }

    if ($request->has('facilities')) {
        foreach ($request->facilities as $facilityId) {
            DB::table('property_facilities')->insert([
                'property_id' => $propertyId,
                'facility_id' => $facilityId,
            ]);
        }
    }

    return back()->with('success','Room added successfully');
}


/* ===========================
   UPDATE ROOM
=========================== */

public function updateRoom(Request $request, $id)
{
    DB::table('properties')
        ->where('id', $id)
        ->update([
            'name'        => $request->name,
            'min_guests'  => $request->min_guests,
            'max_guests'  => $request->max_guests,
            'base_price'  => $request->base_price,
            'status'      => $request->status,
            'is_featured' => $request->is_featured ?? 0,
            'updated_at'  => now()
        ]);

    return back()->with('success', 'Room updated successfully');
}







}
