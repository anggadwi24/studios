@extends('layouts.theme_form')

@section('content')


                <form action="{{ route('submodul.store')}}" method = "POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                      <div class="col-sm-12 form-group">
                        <label for="">Modul</label>
                        <select name="modul" class="form-control" >
                            <option selected disabled>Pilih Modul</option>
                            @foreach($record->toArray() as $row)
                            <option value="{{ $row['modul_id']}}">{{ $row['modul_name']}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-5 offset-md-7 ">
                            <div class="row row-cols-lg-auto g-3 align-items-end justify-content-end">
                                <div class="col-12">
                                    <input type="number" name="tot" id="tot" value="1" class="form-control float-end ">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-icon mb-1 me-4 float-end" id="sbmTot"><i data-feather="plus"></i></button>
                                </div>
                            </div>
                           
                                                
                           
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="row" id="tampilInput"></div>
                                                    
                        </div>
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

          
             



@endsection