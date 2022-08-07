<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['subtitle'] = 'Dashboard';

        $data['breadcrumb'] = ' <li class="breadcrumb-item active" aria-current="page">Dashboard</li>';
        return view('dashboard.main',$data);
    }
    public function dataMenu(){
        $user = auth()->user();
        $id = $user->users_id;
        $output = '<li class="menu active">
                        <a href="'.route('dashboard').'" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </li>';
        $modul = DB::table('users_modul')
            ->join('moduls','users_modul.umod_modul_id','=','moduls.modul_id')
       
            ->where('umod_users_id',$id)
            ->groupBy('umod_modul_id')
            ->orderBy('modul_order','ASC')
            ->get();
        $submodul = null;
        if($modul->count() > 0){
            foreach($modul as $mod){
                $submodul = DB::table('users_modul')
                    ->join('submoduls','users_modul.umod_submodul_id','=','submoduls.submodul_id')
                  
                    ->where('umod_users_id',$id)
                    ->where('umod_modul_id',$mod->umod_modul_id)
                    ->where('submodul_publish','y')
                    ->orderBy('submodul_id','ASC')
                    ->get();
                   
                if($submodul->count() > 0){
            
                    $output .= '<li class="menu">
                    <a href="#'.$mod->modul_slug.'" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i data-feather="'.$mod->modul_icon.'"></i>
                            <span>CMS</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="'.$mod->modul_slug.'" data-bs-parent="#accordionExample">
                    ';
                    foreach($submodul as $sub){
                        $output .= '<li>
                                        <a href="'.route($sub->submodul_slug).'"> '.$sub->submodul_name.' </a>
                                    </li>
                        ';
                    }
                    $output .='     
                            </ul>
                        </li>';
                        
                }else{
                    $output .= ' <li class="menu">
                    <a href="'.route($mod->modul_slug).'" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i data-feather="'.$mod->modul_icon.'"></i>
    
                            <span>'.$mod->modul_name.'</span>
                        </div>
                    </a>
                </li>';
                }
            }
        }
        return response()->json($output);
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
        //
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
    }
}
