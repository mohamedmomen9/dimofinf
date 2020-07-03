@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Company</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <form method="post" action="{{ route('companies.store') }}">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Company Name"/>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="email" placeholder="Compnay Email">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="website_url" placeholder="Compnay Website">
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="form-group custom-file">
                    <input type="file" class="custom-file-input  form-control" name="logo" placeholder="Upload logo file">
                    <label class="custom-file-label" for="logo">Compnay Logo</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
@endsection
