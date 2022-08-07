@extends('layouts.theme_form')
@section('content')

        <form action="{{ route('user.update',$id)}}" method = "POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-4">
        
                <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
                    <div class="form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control mb-3" id="fullName" placeholder="Full Name" name="name" value="{{ $row['users_name']}}" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profession">Email</label>
                                    <input type="email" class="form-control mb-3" id="profession" placeholder="Email" name="email" value="{{ $row['users_email']}}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Level</label>
                                    <select class="form-select mb-3" id="country" name="level">
                                        <option value="user" @if($row['users_level'] == 'user') selected @endif>User</option>
                                        <option value="admin" @if($row['users_level'] == 'admin') selected @endif>Admin</option>

                                      
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Password</label>
                                    <input type="password" class="form-control " id="address" name="password" placeholder="Password" >
                                    <small id="sh-text1" class="form-text text-danger">Fill if you want change password</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Photo</label>
                                    <input type="file" class="form-control file-upload-input"
                                     name="file" id="files" accept="image/png, image/jpeg, image/jpg" />
                                     <small id="sh-text1" class="form-text text-danger">Fill if you want change photo profile</small>
                                </div>
                            </div>
                           

                            <div class="col-md-12 mt-1">
                                <div class="form-group text-end">
                                    <button class="btn btn-secondary">Save</button>
                                </div>
                            </div>
                            
                        </div>
            </div>
        
        </form>
@endsection