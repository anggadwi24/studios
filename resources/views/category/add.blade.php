@extends('layouts.theme_form')
@section('content')


    
            <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-4">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Category</label>
                        <input type="text" class="form-control" id="inputEmail4" name="category" placeholder="Category">
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Image</label>
                        <input type="file" class="form-control" id="inputAddress" name="file" placeholder="Image" accept="image/*">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary float-end">Submit</button>
            </form>

@endsection