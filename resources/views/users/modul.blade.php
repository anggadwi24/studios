@extends('layouts.theme_profile')
@section('content')
<?php 
    if (file_exists('storage/user/').$row['users_photo']) {
        $img = url('storage/user/'.$row['users_photo']);
    }else{
        $img = asset('public/user/default.png');
    }
?>
<div class="row layout-top-spacing">
    <h2><?= $subtitle ?></h2>
    <div class="col-xl-4 col-lg-4 col-sm-12  layout-spacing">
        <div class="user-profile">
            <div class="widget-content widget-content-area">
                <div class="d-flex justify-content-between">
                    <h3 class="">Profile</h3>
                    <a href="{{ route('user.edit',$id)}}" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                </div>
                <div class="text-center user-info">
                    <img src="{{ $img }}" alt="avatar">
                    <p class="">{{ $row['users_name']}}</p>
                </div>
                <div class="user-info-list">

                    <div class="">
                        <ul class="contacts-block list-unstyled" style="max-width:250px !important">
                            <li class="contacts-block__item">
                                <a href="mailto:{{ $row['users_email']}}"> <i data-feather="mail" class="me-3"></i> {{ $row['users_email']}}</a>
                            </li>
                            <li class="contacts-block__item">
                               <i data-feather="user" class="me-3"></i> {{ ucfirst($row['users_level'])}}
                            </li>
                           
                      
                    </div>                                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-8">
            <form action="{{route('user.modul.store',$id)}}" method="POST">
                @csrf
                <div class="row">
                    {{-- @foreach($modules as $mod) --}}
                    <?= $output ?>
                    {{-- @endforeach --}}
                </div>
                <div class="row ">
                    <div class="col-12">
                         <button class="btn btn-primary float-end">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?=  $modules ?>
</div>
<script>
    $(document).on('click','.checkboxes',function(){


var __target = $(this).attr('target');
var classes = '.'+__target;

$(classes).prop('checked', this.checked);
});
</script>
@endsection