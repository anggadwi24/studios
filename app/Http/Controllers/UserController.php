<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\User_modul;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        if (Auth::check())
        {
            $this->id =  auth()->user()->users_id;
            if(__getAccess($this->id,'user')){
                
            }else{
               

               Alert::error('Oopss', 'You cant access this page');
                Redirect::to('dashboard')->send();
            }
        }else{
            redirect('auth');
        }
      
    }
    public function index()
    {
        if(__getAccess($this->id,'user')){
            $data['title'] = 'Users';
            $data['subtitle'] = 'Users';
            if(__getAccess($this->id,'user')){
                $data['right'] = '  <a href="'. route('user.add').'" class="btn btn-success btn-icon float-end mt-4"><i data-feather="plus"></i></a>';
            }else{
                $data['right'] = '';
            }
            $data['breadcrumb'] = ' <li class="breadcrumb-item active" aria-current="page">Users</li>';
            // $data['record'] = Submodul::all();
            $data['js'] = 'user/ajax-users.js';
            return view('users.user',$data);
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $id = auth()->user()->users_id;
        $data = User::all();
        $output = ' <table id="table" class="table dt-table-hover" style="width:100%" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Active</th>
                            
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        if(count($data) > 0){
           $no=1;
            foreach($data->toArray() as $row){
                if (file_exists('storage/user/').$row['users_photo']) {
                    $img = url('storage/user/'.$row['users_photo']);
                }else{
                    $img = asset('public/user/default.png');
                }
                if($row['users_active'] == 'y'){
                    $act = 'Active';
                }else{
                    $act = 'Not Active';
                }
              $output .= ' <tr>
              <td>'.$no.'</td>
              <td>
                <div class="media">
                    <div class="avatar me-2">
                        <img alt="avatar" src="'.$img.'" class="rounded-circle" />
                    </div>
                    <div class="media-body align-self-center">
                        <h6 class="mb-0">'.$row['users_name'].'</h6>
                        <span>'.$row['users_email'].'</span>
                    </div>
                </div>
              </td>
              <td>'.ucfirst($row['users_level']).'</td>
              <td>'.$act.'</td>

              <td>
              <div class="action-btns">

                 
            ';
            if(__getAccess($id,'user.edit')){
                $output .= ' <a href="'.route('user.edit',['id'=>Crypt::encrypt($row['users_id'])]).'" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Edit"><i data-feather="edit"></i></a>';
            
                if($row['users_active'] == 'y'){
                    $output .= '<a href="'.route('user.setting',['id'=>Crypt::encrypt($row['users_id']),'status'=>Crypt::encryptString('n')]).'" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Unactive"><i data-feather="x"></i></a>';

                }else{
                    $output .= '<a href="'.route('user.setting',['id'=>Crypt::encrypt($row['users_id']),'status'=>Crypt::encryptString('y')]).'" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Active"><i data-feather="check"></i></a>';
                }
            }
            if(__getAccess($id,'user.modul')){
                $output .= '<a href="'.route('user.modul',['id'=>Crypt::encrypt($row['users_id'])]).'" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Modul"><i data-feather="settings"></i></a>';
            }
            if(__getAccess($id,'user.delete')){
                $output .=' <a href="'.route('user.delete',Crypt::encrypt($row['users_id'])).'" class="action-btn btn-delete bs-tooltip me-2 text-danger" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete"><i data-feather="trash"></i></a>
            ';
            }
            $output .='
              </div>
            
              </td>
              </tr>';
              $no++;
            }
        }
        $output .= '</tbody>';
        $output .= '</table>';
        return response()->json($output,200);
    }
    public function setting($id,$status){
        if(__getAccess($this->id,'user.edit')){
            try{
                $id = Crypt::decrypt($id);
                $status = Crypt::decryptString($status);
                $row = User::findOrFail($id);
                if($row){
                    $row->users_active = $status;
                    $row->save();
                    if($status == 'y'){
                         Alert::success('Success', 'User Active');
                    }else{
                         Alert::success('Success', 'User Unactive');
                    }
                
                    return redirect()->back();
                }else{
                     Alert::error('Error', 'Users not found');
                    return redirect()->back();
                }
            }catch(DecryptException $e){
                 Alert::error('Error', 'Something Wrong');
                return redirect()->back();
            }
        }else{
             Alert::error('Error', 'You dont have access');
            return redirect()->back();
        }
    }
    public function add(){
        if(__getAccess($this->id,'user.add')){
            $data['subtitle'] = 'Users';
            $data['title'] = 'Add User';
            $data['right'] = ' ';
            $data['page'] = 'Form Add Users';
            $data['breadcrumb'] = ' <li class="breadcrumb-item " ><a href="'.route('user').'">Users</a></li>';
            $data['breadcrumb'] .= ' <li class="breadcrumb-item active" aria-current="page">Add User</li>';
        
            return view('users.add',$data);
        }else{
            Alert::error('Error', 'You dont have access');
           return redirect()->back();
       }
    }
    public function store(Request $request)
    {
        // dd($request->all());
        if(__getAccess($this->id,'user.add')){
        $validator = Validator::make($request->all(), [
       
            'email'=> 'required|max:255|min:10|unique:users,users_email|email',
            'name' => 'required|max:255|min:6',
            'level' => 'required',
            'password'=> 'required|max:25|min:6',
        ]);
            if($validator->fails()){
                $msg = $validator->errors()->all();
                 Alert::error('Error',  $msg);
                return redirect()->back()->withInput();
            }else{
                if($request->file('file')){
                    $validator = Validator::make($request->all(), [
                        'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ]);
                    if($validator->fails()){
                        $msg = $validator->errors()->all();
                         Alert::error('Error',  $msg);
                        return redirect()->back()->withInput();
                    }else{
                        $filename = 'profile-photo-' . time() . '.' . $request->file('file')->getClientOriginalExtension();
 
                        $path = $request->file('file')->storeAs('public/user',$filename);
                        
                        /* Store $fileName name in DATABASE from HERE */
                        $photo = $filename;
                        $user = new User;
                        $user->users_email = $request->input('email');
                        $user->users_name = $request->input('name');
                        $user->users_level = $request->input('level');
                        $user->users_password = bcrypt($request->input('password'));
                        $user->users_photo = $photo;
                        $user->users_active = 'y';
                        $user->save();
                         Alert::success('Success',  'Users has been created');
                        return redirect()->route('user');
                    }
                    
                }else{
                    $photo = 'default.png';
                    $user = new User;
                    $user->users_email = $request->input('email');
                    $user->users_name = $request->input('name');
                    $user->users_level = $request->input('level');
                    $user->users_password = bcrypt($request->input('password'));
                    $user->users_photo = $photo;
                    $user->users_active = 'y';
                    $user->save();
                     Alert::success('Success',  'Users has been created');
                    return redirect()->route('user');
          
                }
              
            }
            }else{
                Alert::error('Error', 'You dont have access');
               return redirect()->back();
            }
    
          
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(__getAccess($this->id,'user.edit')){
            try{
                $id = Crypt::decrypt($id);
                $row = User::findOrFail($id);
                if($row){
                    $data['id'] = Crypt::encrypt($id);
                    $data['row'] = $row->toArray();
                    $data['subtitle'] = 'Users';
                    $data['title'] = 'Edit User';
                    $data['right'] = ' ';
                    $data['page'] = 'Form Edit Users';
                    $data['breadcrumb'] = ' <li class="breadcrumb-item " ><a href="'.route('user').'">Users</a></li>';
                    $data['breadcrumb'] .= ' <li class="breadcrumb-item active" aria-current="page">Edit</li>';
                    // $data['js'] = 'user/ajax-edit-user.js';
                    return view('users.edit',$data);
                }else{
                    Alert::error('Error',  'Users not found');
                    return redirect()->route('user');
                }
            }catch(DecryptException $e){
                Alert::error('Error',  'Something Wrong');
                return redirect()->route('user');
            }
        }else{
            Alert::error('Error', 'You dont have access');
            return redirect()->back();
        }
    }
    public function modul($id)
    {
        if(__getAccess($this->id,'user.modul')){
            try{
                $id = Crypt::decrypt($id);
                $row = User::findOrFail($id);
                if($row){
                    $data['id'] = Crypt::encrypt($id);
                
                    $data['row'] = $row->toArray();
                    $data['subtitle'] = 'Users';
                    $data['title'] = 'Modul';
                    $data['right'] = ' ';
                    $data['page'] = 'Modul Users';
                    $data['breadcrumb'] = ' <li class="breadcrumb-item " ><a href="'.route('user').'">Users</a></li>';
                    $data['breadcrumb'] .= ' <li class="breadcrumb-item active" aria-current="page">Modul</li>';
                    $modul = DB::table('moduls')->orderBy('modul_order','ASC')->get();
                    // $data['js'] = 'user/ajax-edit-user.js';
                    $output = null;
                    $modules = null;
                    if($modul->count() > 0){
                        foreach($modul as $mod){
                            $output .= '   <div class="col-xl-6 col-lg-6 col-sm-12">
                                            
                                                <div class="row"> 
                                                    <div class="col-md-12 mb-2"> <h6>'.$mod->modul_name .'</h6></div>
                                                    <div class="col-md-12 mb-1 ">
                                                        <span style="display:block"><input name="checkboxes" class="checkboxes" type="checkbox" target="'.str_replace(" ","_",strtolower($mod->modul_name)).'" /> Check all</span> 

                                                        
                                                    </div>
                                        ';

                            $submodul = DB::table('submoduls')->where('submodul_modul_id',$mod->modul_id)->orderBy('submodul_name','ASC')->get();
                            if($submodul->count() > 0){
                                foreach($submodul as $sub){
                                    $umod = DB::table('users_modul')->where('umod_users_id',$id)->where('umod_modul_id',$sub->submodul_modul_id)->where('umod_submodul_id',$sub->submodul_id)->get();
                                    if($umod->count() == 0){
                                        $output .= "<div class='col-md-12'>
                                                        <span style='display:block'><input name='modul[]' type='checkbox' class='".str_replace(' ','_',strtolower($mod->modul_name))."' value='".$sub->submodul_modul_id.'|'.$sub->submodul_id."' /> ". $sub->submodul_name ."</span> 
                                                    </div>";
                                    }
                                }
                            }
                            $output .= '</div>';
                            $output .= '</div>';
                        }
                    }
                    if($modul->count() > 0){
                        foreach($modul as $mods){
                            $user_mod  = DB::table('users_modul')->where('umod_users_id',$id)->where('umod_modul_id',$mods->modul_id)->get();
                            if($user_mod->count() > 0){
                                $modules .= '<div class="col-xl-3 col-lg-3 col-sm-6  layout-spacing">
                                <div class="widget-content widget-content-area br-8">
                                    <div class="d-flex justify-content-between">
                                    <h3 class="">'.$mods->modul_name.'</h3>
                                    </div>
                                    <div class="row">
                                    
                                ';
                            $submods=  DB::table('submoduls')
                                            ->join('moduls', 'submoduls.submodul_modul_id', '=', 'moduls.modul_id')
                                            ->join('users_modul', 'submoduls.submodul_id', '=', 'users_modul.umod_submodul_id')
                                            ->select('*')
                                            ->where('users_modul.umod_users_id',$id)
                                            ->where('users_modul.umod_modul_id',$mods->modul_id)
                                            ->orderBy('umod_id','asc')
                                            ->get();
                                if($submods->count() > 0){
                                    foreach($submods as $sm){
                                        $modules .= '<div class="col-md-12 mt-2">
                                                        <div class="row align-items-center">
                                                            <h6 class="text-start col-8 ">'.$sm->submodul_name.'</h6>
                                                            <a class="col-4 text-end bs-tooltip " data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete" href="'.route('user.modul.delete',Crypt::encrypt($sm->umod_id)).'"><i data-feather="trash" class="text-danger"></i></a>
                                                        </div>
                                                    </div>';
                                    }
                                }
                                $modules .='  
                                    </div>
                                </div>
                            </div>';
                            }
                        }
                        
                    }
                    $data['modules'] = $modules;
                    $data['output'] = $output;
                    return view('users.modul',$data);
                }else{
                    Alert::error('Error',  'Users not found');
                    return redirect()->route('user');
                }
            }catch(DecryptException $e){
                Alert::error('Error',  'Something Wrong');
                return redirect()->route('user');
            }
        } else{
            Alert::error('Error', 'You dont have access');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function find(){
        Alert::info('Title','Lorem Lorem Lorem');
        return redirect()->route('user');
    }
    public function deleteAkses($id){
        if(__getAccess($this->id,'user.modul')){
            try {
                $id = Crypt::decrypt($id);
                $user = DB::table('users_modul')->where('umod_id',$id)->get();
                if($user->count() > 0){
                    DB::table('users_modul')->where('umod_id',$id)->delete();
                    Alert::success('Success',  'Successfully delete akses');
                    return redirect()->route('user.modul',Crypt::encrypt($user[0]->umod_users_id));
                }else{
                    Alert::error('Error',  'Akses not found');
                    return redirect()->back();
                }

            }catch(DecryptException $e){
                Alert::error('Error',  'Something Wrong');
                return redirect()->back();
            }
        }else{
            Alert::error('Error', 'You dont have access');
            return redirect()->back();
        }
    }
    public function update(Request $request, $id)
    {
        if(__getAccess($this->id,'user.edit')){
            try{
                $id = Crypt::decrypt($id);
                $row = User::findOrFail($id);   
                if($row){
                    $validator = Validator::make($request->all(), [
                        'email'=> 'required|max:255|min:10|unique:users,users_email,'.$id.',users_id|email',
                        'name' => 'required|max:255|min:6',
                        'level' => 'required',
                        
                    ]);
                    if($validator->fails()){
                        $msg = $validator->errors()->all();
                        Alert::error('Error',  $msg);
                        return redirect()->back()->withInput();
                    }else{
                        if($request->file('file')){
                            $validator = Validator::make($request->all(), [
                                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            ]);
                            if($validator->fails()){
                                $msg = $validator->errors()->all();
                                Alert::error('Error',  $msg);
                                return redirect()->back()->withInput();
                            }else{
                                $filename = 'profile-photo-' . time() . '.' . $request->file('file')->getClientOriginalExtension();
    
                                $path = $request->file('file')->storeAs('public/user',$filename);
                                
                                /* Store $fileName name in DATABASE from HERE */
                                $photo = $filename;
                                $user = User::findOrFail($id);
                                $user->users_email = $request->input('email');
                                $user->users_name = $request->input('name');
                                $user->users_level = $request->input('level');
                                if($request->input('password')){
                                    $user->users_password = bcrypt($request->input('password'));
                                }
                        
                                $user->users_photo = $photo;
                                $user->save();
                                Alert::success('Success',  'Users has been updated');
                                return redirect()->route('user');
                            }
                        }else{
                            $user = User::findOrFail($id);
                            $user->users_email = $request->input('email');
                            $user->users_name = $request->input('name');
                            $user->users_level = $request->input('level');
                            if($request->input('password')){
                                $user->users_password = bcrypt($request->input('password'));
                            }
                            $user->save();
                            Alert::success('Success',  'Users has been updated');
                            return redirect()->route('user');
                        }
                    }
                }else{
                    Alert::error('Error',  'Users not found');
                    return redirect()->route('user');
                }
            } catch(DecryptException $e){
                Alert::error('Error',  'Something Wrong');
                return redirect()->route('user');
            }
        }else{
            Alert::error('Error', 'You dont have access');
            return redirect()->back();
        }
    }
    public function storeModul(Request $request, $id)
    {
        if(__getAccess($this->id,'user.modul')){
        // return $request;
            try{
                $id = Crypt::decrypt($id);
                $row = User::findOrFail($id);   
                if($row){
                    $validator = Validator::make($request->all(), [
                        'modul'=> 'required',
                        'modul.*' => 'required|distinct',
                        
                        
                    ]);
                    if($validator->fails()){
                        $msg = $validator->errors()->all();
                        Alert::error('Error',  $msg);
                        return redirect()->back()->withInput();
                    }else{
                        $modul = $request->post('modul');
                    
                        if(count($modul) > 0){
                            foreach($modul as $key => $value){
                                $ex = explode('|',$modul[$key]);
                            
                                $data = new User_modul;
                                $data->umod_modul_id = $ex[0];
                                $data->umod_submodul_id = $ex[1];
                                $data->umod_users_id = $id;
                            
                                $data->save();
                            }
                            Alert::success('Success', 'Modul has been saved');
                            return redirect()->back();
                        }else{
                            Alert::error('Warning', 'Modul cannot be null');
                            return redirect()->back();
                        }
                    }
                }else{
                    Alert::error('Error',  'Users not found');
                    return redirect()->route('user');
                }
            } catch(DecryptException $e){
                Alert::error('Error',  'Something Wrong');
                return redirect()->route('user');
            }
        }else{
            Alert::error('Error', 'You dont have access');
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(__getAccess($this->id,'user.delete')){
            try{
                $id = Crypt::decrypt($id);
                $row = User::findOrFail($id);
                if($row){
                    $row->delete();
                    Alert::success('Success',  'Users has been deleted');
                    return redirect()->route('user');
                }else{
                    Alert::error('Error',  'Users not found');
                    return redirect()->route('user');
                }
            }catch(DecryptException $e){
                Alert::error('Error',  'Something Wrong');
                return redirect()->route('user');
            }
        }else{
            Alert::error('Error', 'You dont have access');
            return redirect()->back();
        }
    }
}
