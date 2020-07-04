<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use Illuminate\Http\Request;
use App\Notifications\CompanyAdded;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
        if(Auth::guest())
        {
            return redirect('/login')->with('message', 'Please Login first!');;
        }
        $request->validate([
            'name'  => 'required',
            'email' => 'email',
            'website_url' => 'url',
            'logo'  => 'mimes:jpeg,png,jpg,gif,svg|image|dimensions:min_width=100,min_height=100'
        ]);
        //Not recomended 
        $image = $request->file('logo');
        $fileName = $this->saveLogo($image);

        $company = new Company([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'website_url' => $request->get('website_url'),
            'logo' => $fileName,
        ]);
        $company->save();
        User::find(1)->notify(new CompanyAdded($company));
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
            'name'  => 'required',
            'email' => 'email',
            'website_url' => 'url',
            'logo'  => 'mimes:jpeg,png,jpg,gif,svg|image|dimensions:min_width=100,min_height=100'
        ]);

        $image = $request->file('logo');
        $fileName = $this->saveLogo($image);
    
        $company = Company::find($id);
        $company->name =  $request->get('name');
        $company->email = $request->get('email');
        $company->website_url = $request->get('website_url');
        $company->logo = $fileName;
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

    public function saveLogo($image){
        $fileName   = time() . '.' . $image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();                 
        });
        $img->stream();
        Storage::disk('local')->put('/public/'.$fileName, $img, 'public');
        return $fileName;
    }
}
