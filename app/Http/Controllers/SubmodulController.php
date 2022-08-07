<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Submodul;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;


class SubmodulController extends Controller
{
    public function __construct()
    {
        if (Auth::check())
        {
            $this->id =  auth()->user()->users_id;
            if(__getAccess($this->id,'submodul')){
                
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
        if(__getAccess($this->id,'submodul')){
                
       
            $data['subtitle'] = 'Submodul';
            $data['title'] = 'Submodul';
            if(__getAccess($this->id,'submodul.add')){
                $data['right'] = '  <a href="'. route('submodul.add').'" class="btn btn-success btn-icon float-end mt-4"><i data-feather="plus"></i></a>';
            }else{
                $data['right'] = '';
            }
            $data['breadcrumb'] = ' <li class="breadcrumb-item active" aria-current="page">Submodul</li>';
            // $data['record'] = Submodul::all();
            $data['js'] = 'cms/ajax-submodul.js';
            return view('submodul.submodul',$data);
        }else{
            

            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
    }
    function data(){
        $data = DB::table('submoduls')
        ->join('moduls', 'submoduls.submodul_modul_id', '=', 'moduls.modul_id')
        ->select('*')
        ->orderBy('submodul_id','desc')
        ->get();
        $output = null;
        $output = ' <table id="table" class="table dt-table-hover" style="width:100%" >
        <thead>
            <tr>
                <th>No</th>
                <th>Modul</th>
                <th>Submodul</th>
                <th>Slug</th>
                <th>Publish</th>

                
                <th class="no-content">Action</th>
            </tr>
        </thead>
        <tbody>';
        if(count($data) > 0){
            $no = 1;
            $record =json_decode($data, true);
            foreach($record as $row){
                if($row['submodul_publish'] == 'y'){
                    $pub = '<i>Publish</i>';
                }else{
                    $pub = '<i>Unpublish</i>';
                }
                $output .= ' <tr>
                                <td>'.$no.'</td>  
                                <td>'.$row['modul_name'].'</td>
                                <td>'.$row['submodul_name'].'</td>
                                <td>'.$row['submodul_slug'].'</td>
                                <td>'.$pub.'</td>
                                <td class="no-content">
                                <div class="action-btns">
                                    <a href="'.route('submodul.edit',Crypt::encrypt($row['submodul_id'])).'" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Edit"><i data-feather="edit"></i></a>
                                    <a href="'.route('submodul.delete',Crypt::encrypt($row['submodul_id'])).'" class="action-btn btn-delete bs-tooltip me-2 text-danger" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete"><i data-feather="trash"></i></a>
                              </div>
                                    
                                </td>

                            </tr>';
                $no++;
            }
        }
        $output .= '</tbody></tabel>';
        return response()->json($output,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        if(__getAccess($this->id,'submodul.add')){
            $data['subtitle'] = 'Submodul';

            $data['record'] = Modul::all();
            $data['right'] = '';
            $data['title'] = 'Add Submodul';
            $data['page'] = 'Form Add Submodul';
            $data['breadcrumb'] = ' <li class="breadcrumb-item " ><a href="'.route('submodul').'">Submodul</a></li>';
            $data['breadcrumb'] .= ' <li class="breadcrumb-item active" aria-current="page">Add</li>';
            $data['js'] = 'cms/ajax-submodul-add.js';
           
            return view('submodul.add',$data);
        }else{
           

           Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(__getAccess($this->id,'submodul.add')){
            $validator = Validator::make($request->all(), [
                'modul' => 'required',
                'submodul' => 'required',
                'submodul.*' => 'required|distinct',
            
                'slug' => 'required',

                'slug.*' => 'required|distinct',
                'publish' => 'required',

                'publish.*' => 'required',

                
            ]);
        
        
        
            if ($validator->fails()) {
                $msg = $validator->errors()->all();
            
                Alert::error('Warning', $msg);
                return redirect()->route('submodul.add');
            
            }else{
                $modul = Modul::findOrFail($request->input('modul'));
                if($modul){
                    $submodul = $request->input('submodul');
                    $slug = $request->input('slug');
                    $publish = $request->input('publish');
                    if(count($submodul) > 0){
                        foreach($submodul as $key => $value){
                            $data = new Submodul();
                            $data->submodul_modul_id = $modul->modul_id;
                            $data->submodul_name = $value;
                            $data->submodul_slug = $slug[$key];
                            $data->submodul_publish = $publish[$key];
                            $data->save();
                        }
                        Alert::success('Success', 'Submodul has been saved');
                        return redirect()->route('submodul');
                    }else{
                        Alert::error('Warning', 'Submodul cannot be null');
                        return redirect()->route('submodul.add');
                    }
                }else{
                    Alert::error('Warning', 'Modul not found');
                    return redirect()->route('submodul.add');
                }
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
        if(__getAccess($this->id,'submodul.edit')){
            try {
            
                $id = Crypt::decrypt($id);
        
                $row = Submodul::findOrFail($id);
                if($row){
                    $data['subtitle'] = 'Submodul';

                    $data['id'] = Crypt::encrypt($id);
                    $data['row'] = $row->toArray();
                    $data['right'] = '';
                    $data['record'] = Modul::all();
                    $data['title'] = 'Edit Submodul';
                    $data['page'] = 'Form Edit Submodul';
                    $data['breadcrumb'] = ' <li class="breadcrumb-item " ><a href="'.route('submodul').'">Submodul</a></li>';
                    $data['breadcrumb'] .= ' <li class="breadcrumb-item active" aria-current="page">Edit</li>';
                    return view('submodul.edit',$data);
                }else{
                    Alert::error('Warning', 'Submodul not found');
                    return redirect()->route('submodul');
                }
            } catch (DecryptException $e) {
                //
                Alert::error('Warning', 'Something wrong!');
                return redirect()->route('submodul');
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
        if(__getAccess($this->id,'submodul.edit')){
            try{
                $id = Crypt::decrypt($id);
                $submodul = new Submodul;
                $submodul = Submodul::findOrFail($id);
                if($submodul){
                    $validator = Validator::make($request->all(), [
                        'modul' => 'required',
                        'submodul' => 'required',
                        'slug' => 'required',                 
                        'publish' => 'required',
                        
                    ]);
                    if($validator->fails()){
                        $msg = $validator->errors()->all();
                        Alert::error('Warning', $msg);
                        return redirect()->route('submodul.edit',Crypt::encrypt($id));
                    }else{
                        $submodul->submodul_name = $request->input('submodul');
                        $submodul->submodul_slug = $request->input('slug');
                        $submodul->submodul_publish = $request->input('publish');
                        $submodul->submodul_modul_id = $request->input('modul');
                        $submodul->save();
                        Alert::success('Success','Submodul has been updated');
                        return redirect()->route('submodul');
                    }
                }else{
                    Alert::error('Warning', 'Submodul not found');
                    return redirect()->route('submodul');
                }
            

            } catch(DecryptException $e){
                Alert::error('Warning', 'Something wrong!');
                return redirect()->route('submodul');
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
        if(__getAccess($this->id,'submodul.delete')){
            try{
                $id = Crypt::decrypt($id);
            
                $submodul = Submodul::findOrFail($id);
                if($submodul){
                    $submodul->delete();
                    Alert::success('Success','Submodul has been deleted');
                    return redirect()->route('submodul');
                }else{
                    Alert::error('Warning', 'Submodul not found');
                    return redirect()->route('submodul');
                }
        
            }catch(DecryptException $e){
                Alert::error('Warning', 'Something wrong!');
                return redirect()->route('submodul');
            }
        } else{
        

            Alert::error('Oopss', 'You cant access this page');
                Redirect::to('dashboard')->send();
        }
    }
}
