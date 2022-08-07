@extends('layouts.theme_form')
@section('content')


<form action="{{ route('submodul.update',$id)}}" method = "POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-4">
      <div class="col-sm-12 form-group">
        <label for="">Modul</label>
        <select name="modul" class="form-control" >
            <option selected disabled>Pilih Modul</option>
            @foreach($record->toArray() as $mod)
                @if ($mod['modul_id'] == $row['submodul_modul_id'])
                    <option value="{{ $mod['modul_id']}}" selected>{{ $mod['modul_name']}}</option>
                @else 
                    <option value="{{ $mod['modul_id']}}">{{ $mod['modul_name']}}</option>
                @endif
      
            @endforeach
        </select>
      </div>
    </div>
    <div class="row mb-4">
     
        <div class="col-md-4 ">
            <label for="" class="form-label">Submodul</label>
            <input type="text" class="form-control" name="submodul" value="{{ $row['submodul_name']}}">
                                    
        </div>
        <div class="col-md-4 ">
            <label for="" class="form-label">Slug</label>
            <input type="text" class="form-control" name="slug" value="{{ $row['submodul_slug']}}">
                                    
        </div>
        <div class="col-md-4 ">
            <label for="" class="form-label">Publish</label>
            <select name="publish" id="" class="form-control" >
                <option value="y" @if ($row['submodul_publish'] == 'y') selected @endif>Publish</option>
                <option value="n" @if ($row['submodul_publish'] == 'n') selected @endif>Unpublish</option>
            </select>
                                    
        </div>
    </div>
   
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection