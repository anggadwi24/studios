<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

class CategoryController extends Controller
{
    public function __construct()
    {
        if (Auth::check())
        {
            $this->id =  auth()->user()->users_id;
            if(__getAccess($this->id,'category')){
                
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
        if(__getAccess($this->id,'category')){
            $data['title'] = 'Category';
            $data['subtitle'] = 'Category';
            if(__getAccess($this->id,'category.add')){
                $data['right'] = '  <a href="'. route('category.add').'" class="btn btn-success btn-icon float-end mt-4"><i data-feather="plus"></i></a>';
            }else{
                $data['right'] = '';
            }
            //  Alert::error('Oopss', 'You cant access this page');
            $data['js'] = 'category/ajax-category.js';
            $data['breadcrumb'] = ' <li class="breadcrumb-item active" aria-current="page">Category</li>';
            return view('category.index',$data);
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
    }
    
    public function data(){
        $data = Category::all();
        $output = ' <table id="table" class="table dt-table-hover" style="width:100%" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category</th>
                          
                            
                            <th class="no-content">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        if(__getAccess($this->id,'category')){
            if(count($data) > 0){
                $no = 1;
                foreach($data->toArray() as $row){

                $output .= ' <tr>
                <td>'.$no.'</td>
                <td>'.$row['cat_category'] .'</td>
              
                <td class="no-content">
                    <div class="action-btns">
                ';
                if(__getAccess($this->id,'category.edit')){
                    $output .='<a href="'.route('category.edit',['id'=>Crypt::encrypt($row['cat_id'])]).'" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Edit"><i data-feather="edit"></i></a>';
                }
                if(__getAccess($this->id,'category.delete')){
                    $output .= '  <a href="'.route('category.delete',Crypt::encrypt($row['cat_id'])).'" class="action-btn btn-delete bs-tooltip me-2 text-danger" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Delete"><i data-feather="trash"></i></a>';
                }
                    $output .='    
                        </div>
                    </td>
                </tr>';
                $no ++;
                }
            }
        }
        $output .= '</tbody>
                </table>';
        return response()->json($output,200);
    }
    public function add(){
        if(__getAccess($this->id,'category.add')){
            $data['subtitle'] = 'Category';
            $data['right'] = '';
            $data['title'] = 'Add Category';
            
            $data['page'] = 'Form Add Category';
            $data['breadcrumb'] = ' <li class="breadcrumb-item " ><a href="'.route('category').'">Category</a></li>';
            $data['breadcrumb'] .= ' <li class="breadcrumb-item active" aria-current="page">Add</li>';
           
        
            return view('category.add',$data);
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
    }
    function notif(){
       
        // Redirect::to('category')->send();
        return Redirect::back()->withErrors(['msg' => 'The Message']);
        // return back()->withInput();
    }
    public function store(Request $request){
        if(__getAccess($this->id,'category.add')){
            $validator = Validator::make($request->all(), [
                'category' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                $msg = $validator->errors()->all();
            //     Alert::error('Error',  $msg);
            // Alert::error('Oopss', 'You cant access this page');

                return redirect()->route('category.add')->with('success','whyy');
            }else{
                $slug = strtolower(str_replace(' ','_',$request->post('category')));
                if($request->file('file')){
                    $validator = Validator::make($request->all(), [
                        'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ]);
                    if($validator->fails()){
                        $msg = $validator->errors()->all();
                         Alert::error('Error',  $msg);
                        return redirect('/category/add');
                    }else{
                        $filename = 'category-' . time() . '.' . $request->file('file')->getClientOriginalExtension();
 
                        $path = $request->file('file')->storeAs('public/category',$filename);
                      
                        /* Store $fileName name in DATABASE from HERE */
                        $photo = $filename;
                        $category = new Category;
                        $category->cat_category = $request->category;
                        $category->cat_img = $photo;
                        $category->cat_slug = $slug;
                        
                        $category->save();
                        Alert::success('Success', 'Category has been saved');
                        return redirect()->route('category');
                    }
                }else{
                    $photo = 'default.png';
                
                    $category = new Category;
                    $category->cat_category = $request->category;
                    $category->cat_img = $photo;
                    $category->cat_slug = $slug;
                    $category->save();
                    Alert::success('Success', 'Category has been saved');
                    return redirect()->route('category');
                }
            }
           
        }else{
            Alert::error('Oopss', 'You cant access this page');
            Redirect::to('dashboard')->send();
        }
    }
}
