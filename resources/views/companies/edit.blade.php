@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Company</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif
    <div class="row">
    <form method="post" action="{{ action('CompanyController@update', $company->id) }}" enctype="multipart/form-data">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="form-group">
            <label for="name">Company Name:</label>
            <input type="text" class="form-control" name="name" value={{ $company->name }} />
        </div>
        <div class="form-group">
            <label for="email">Company Email:</label>
            <input type="text" class="form-control" name="email" value={{ $company->email }} />
        </div>
        <div class="form-group">
            <label for="website_url">Company Website:</label>
            <input type="text" class="form-control" name="website_url" value={{ $company->website_url }} />
        </div>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
            </div>
            <div class="form-group custom-file">
                <input type="file" class="custom-file-input  form-control" value={{ $company->website_url }} name="logo" placeholder="Upload logo file">
                <label class="custom-file-label" for="logo">Compnay Logo</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection