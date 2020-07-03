<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $companies = Company::paginate(10);
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'  => 'required',
            'email' => 'email',
            'website_url' => 'url',
            'logo'  => 'dimensions:min_width=100,min_height=100'
        ]);
        dd($request->file('logo'));
        //Not recomended 
        $image = $request->file('logo');
        $fileName   = time() . '.' . $image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();                 
        });
        $img->stream();
        Storage::disk('local')->put('images/1/smalls'.'/'.$fileName, $img, 'public');

        $company = new Company([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'job_title' => $request->get('job_title'),
            'city' => $request->get('city'),
            'country' => $request->get('country')
        ]);
        $company->save();
        return redirect('/companies')->with('success', 'Company saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $company = Company::find($id);
        return view('companies.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $company = Company::find($id);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required'
        ]);

        $company = Company::find($id);
        $company->first_name =  $request->get('first_name');
        $company->last_name = $request->get('last_name');
        $company->email = $request->get('email');
        $company->job_title = $request->get('job_title');
        $company->city = $request->get('city');
        $company->country = $request->get('country');
        $company->save();
        return redirect('/companies')->with('success', 'Company updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $company = Company::find($id);
        $company->delete();
        return redirect('/companies')->with('success', 'Company deleted!');
    }
}
