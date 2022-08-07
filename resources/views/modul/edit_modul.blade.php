@extends('layouts.theme_form')

@section('content')


                <form action="{{ route('modul.update',$id)}}" method = "POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                      <div class="col-sm-12 form-group">
                        <label for="">Modul</label>
                        <input type="text" class="form-control" id="inputEmail1" placeholder="Modul Name" name="modul" value="{{ $row['modul_name']}}">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputPassword1" placeholder="Modul Icon " name="icon" value="{{ $row['modul_icon']}}">
                      </div>
                      <div class="col-sm-6">
                        <input type="number" class="form-control" id="inputConfirmPassword1" placeholder="Modul Order" name="order" value="{{ $row['modul_order']}}">
                      </div>
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

          
             



@endsection