<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $doctors = DB::table('doctors')
            ->when(
                $request->input('name'),
                function ($query, $name) {
                    return $query->where('name', 'like', '%' . $name . '%');
                }
            )
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('pages.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'specialist' => 'required',
            'phone' => 'required|numeric|digits_between:10,14',
            'email' => 'required|email',
            'photo' => 'required|image|mimes:jpeg,png,jpg',
            'address' => 'required',
            'sip' => 'required',
        ]);

        $photo = $request->file('photo');
        $photo->storeAs('public/doctors', $photo->hashName());

        DB::table('doctors')->insert([
            'name' => $request->name,
            'specialist' => $request->specialist,
            'phone' => $request->phone,
            'email' => $request->email,
            'photo' => $photo->hashName(),
            'address' => $request->address,
            'sip' => $request->sip,
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully');
    }

    public function show($id)
    {
        $doctor = DB::table('doctors')->where('id', $id)->first();
        return view('pages.doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = DB::table('doctors')->where('id', $id)->first();
        return view('pages.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'specialist' => 'required',
            'phone' => 'required|numeric|digits_between:10,14',
            'email' => 'required|email',
            'address' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg',
            'sip' => 'required',
        ]);

        $photo = $request->file('photo');
        if ($photo) {
            $photo->storeAs('public/doctors', $photo->hashName());
            DB::table('doctors')->where('id', $id)->update([
                'name' => $request->name,
                'specialist' => $request->specialist,
                'phone' => $request->phone,
                'email' => $request->email,
                'photo' => $photo->hashName(),
                'address' => $request->address,
                'sip' => $request->sip,
            ]);
        } else {
            DB::table('doctors')->where('id', $id)->update([
                'name' => $request->name,
                'specialist' => $request->specialist,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'sip' => $request->sip,
            ]);
        }

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully');
    }

    public function destroy($id)
    {
        DB::table('doctors')->where('id', $id)->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully');
    }
}
