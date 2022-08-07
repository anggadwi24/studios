@extends('layouts.theme_table')

@section('content')
@include('sweetalert::alert')
<div class="row layout-top-spacing">
    <h2><?= $subtitle ?></h2>
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-8" id="contentData">
         
            </table>
        </div>
    </div>
</div>
@endsection