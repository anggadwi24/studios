<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

class ModulController extends Controller
{
    public function __construct()
    {
        if (Auth::check())
        {
            $this->id =  auth()->user()->users_id;
            if(__getAccess($this->id,'modul')){
                
            }else{
               

               Alert::error('Oopss', 'You cant access this page');
                Redirect::to('dashboard')->send();
            }
        }else{
            redirect('auth');
        }
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(__getAccess($this->id,'modul')){
            $data['subtitle'] = 'Modul';
            $data['title'] = 'Modul';
            if(__getAccess($this->id,'modul.add')){
                $data['right'] = '  <a href="'. route('modul.add').'" class="btn btn-success btn-icon float-end mt-4"><i data-feather="plus"></i></a>';
            }else{
                $data['right'] = '';
            }
            $data['breadcrumb'] = ' <li class="breadcrumb-item active" aria-current="page">Modul</li>';
            $data['record'] = Modul::all();
            $data['js'] = 'cms/ajax-modul.js';
            return view('modul.modul',$data);
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
    }
    public function add()
    {
        //
        if(__getAccess($this->id,'modul.edit')){
            $data['subtitle'] = 'Modul';
            $data['right'] = '';
            $data['title'] = 'Add Modul';
            $data['page'] = 'Form Add Modul';
            $data['breadcrumb'] = ' <li class="breadcrumb-item " ><a href="'.route('modul').'">Modul</a></li>';
            $data['breadcrumb'] .= ' <li class="breadcrumb-item active" aria-current="page">Add</li>';

        
            return view('modul.insert_modul',$data);
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
    }
    public function data(){
        $data = Modul::all();
        $output = ' <table id="table" class="table dt-table-hover" style="width:100%" >
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Modul</th>
                            <th>Slug</th>
                            
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        if(count($data) > 0){
           
            foreach($data->toArray() as $row){

              $output .= ' <tr>
              <td>'.$row['modul_order'].'</td>
              <td><i data-feather="'.$row['modul_icon'].'"></i>  '.$row['modul_name'] .'</td>
              <td>'.$row['modul_slug'] .'</td>
              <td class="no-content">
                <div class="action-btns">
            ';
            if(__getAccess($this->id,'modul.edit')){
                $output .='<a href="'.route('modul.edit',['id'=>Crypt::encrypt($row['modul_id'])]).'" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Edit"><i data-feather="edit"></i></a>';
            }
            if(__getAccess($this->id,'modul.delete')){
                $output .= '  <a href="'.route('modul.delete',Crypt::encrypt($row['modul_id'])).'" class="action-btn btn-delete bs-tooltip me-2 text-danger" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete"><i data-feather="trash"></i></a>';
            }
                $output .='    
                  </div>
              </td>
          </tr>';
            }
        }
        $output .= '</tbody>
                </table>';
        return response()->json($output,200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(__getAccess($this->id,'modul.add')){
                $validator = Validator::make($request->all(), [
                    'modul' => 'required',
                    'order' => 'required',
                    'icon' => 'required',
                ]);
            
            
            
                if ($validator->fails()) {
                    $msg = $validator->errors()->all();
                    Alert::error('Warning', $msg);
                    return redirect()->route('addModul');
                
                }else{
                    $modul = new Modul;
                    $name = $request->input('modul');
                    $order = $request->input('order');
                    $icon = $request->input('icon');
                    $slug = strtolower(str_replace(' ','_',$name));
            
                    $modul->modul_name = $name;
                    $modul->modul_order = $order;
                    $modul->modul_icon = $icon;
                    $modul->modul_slug = $slug;
                    $modul->save();
                    Alert::success('Success', 'Successfully created moduls');
                    return redirect()->route('modul');
            
            }
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
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
        $row = Modul::where('modul_id',$id);
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
        //
        if(__getAccess($this->id,'modul.edit')){
            try {
            
                $id = Crypt::decrypt($id);
        
                $modul = Modul::findOrFail($id);
                if($modul){
                    $data['subtitle'] = 'Modul';
                    $data['id'] = Crypt::encrypt($id);
                    $data['row'] = $modul->toArray();
                    $data['right'] = '';
                    $data['title'] = 'Edit Modul';
                    $data['page'] = 'Form Edit Modul';
                    $data['breadcrumb'] = ' <li class="breadcrumb-item " ><a href="'.route('modul').'">Modul</a></li>';
                    $data['breadcrumb'] .= ' <li class="breadcrumb-item active" aria-current="page">Edit</li>';
                    return view('modul.edit_modul',$data);
                }else{
                    Alert::error('Warning', 'Modul not found');
                    return redirect()->route('modul');
                }
            } catch (DecryptException $e) {
                //
                Alert::error('Warning', 'Something wrong!');
                return redirect()->route('modul');
            }
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
        
        
        
        
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(__getAccess($this->id,'modul.edit')){
            try {
            
                $id = Crypt::decrypt($id);
        
                $modul = Modul::findOrFail($id);
                if($modul){
                    $validator = Validator::make($request->all(), [
                        'modul' => 'required',
                        'order' => 'required',
                        'icon' => 'required',
                    ]);
                
                
                
                    if ($validator->fails()) {
                        $msg = $validator->errors()->all();
                        Alert::error('Warning', $msg);
                        return redirect()->route('modul.update',$id);
                    
                    }else{
                        $modul = new Modul;
                        $modul = Modul::find($id);
                        $name = $request->input('modul');
                        $order = $request->input('order');
                        $icon = $request->input('icon');
                        $slug = strtolower(str_replace(' ','_',$name));
                
                        $modul->modul_name = $name;
                        $modul->modul_order = $order;
                        $modul->modul_icon = $icon;
                        $modul->modul_slug = $slug;
                    
                        $modul->update();
                        Alert::success('Success', 'Successfully updated moduls');
                        return redirect()->route('modul');
                
                    }
                }else{
                    Alert::error('Warning', 'Modul not found');
                    return redirect()->route('modul');
                }
            } catch (DecryptException $e) {
                //
                Alert::error('Warning', 'Something wrong!');
                return redirect()->route('modul');
            }
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
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
        //
        if(__getAccess($this->id,'modul.delete')){
            try {
            
                $id = Crypt::decrypt($id);
        
                $modul = Modul::findOrFail($id);
                if($modul){
                    $modul->delete();
                    Alert::success('Success', 'Successfully deleted moduls');
                    return redirect()->route('modul');
                }else{
                    Alert::error('Warning', 'Modul not found');
                    return redirect()->route('modul');
                }
            }catch (DecryptException $e) {
                //
                Alert::error('Warning', 'Something wrong!');
                return redirect()->route('modul');
            }
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
    }
}
