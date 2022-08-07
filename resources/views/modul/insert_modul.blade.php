@extends('layouts.theme_form')

@section('content')


                <form action="{{ route('modul.store')}}" method = "POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                      <div class="col-sm-12 form-group">
                        <label for="">Modul</label>
                        <input type="text" class="form-control" id="inputEmail1" placeholder="Modul Name" name="modul">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputPassword1" placeholder="Modul Icon " name="icon">
                      </div>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" id="inputConfirmPassword1" placeholder="Modul Order" name="order">
                      </div>
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

          
             



@endsection