@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Business</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Manage Business</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="pull-left">
                                <h6 class="card-title txt-dark">Business Import</h6>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <div class="form-wrap row">
                                <div class="col-sm-6 col-md-6">
                                    <b>Select .xlsx file for Import</b>
                                    <p>(Note : Column Format for Import Should be : )</p>
                                    <b> | First Name | Last Name | Designation | Contact Numbers |  Email | Business Name  |  Nature of Trade | Addres |  City  | State | Pincode  |  Lat  | Long | Status | Tags </b>
                                    <br>
                                    <div class="form-wrap mt-10">
                                        <a href="{{route('export.business') }}" class="btn btn-success btn-sm">Download Sample File</a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <form method="POST" action="{{ route('import.business') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group col-sm-12">
                                            {{-- {!! Form::file('businessImport',['onchange'=>"unlock()"]) !!} --}}
                                            <input type="file" name="businessImport" class="form-group" onchange="unlock()" >
                                            <div class="form-wrap">
                                                <button disabled id="buttonSubmit" type="submit" class="btn btn-success btn-sm mt-10">Import Business</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @if(session()->has('failures'))
                                    <div>
                                    <div class="card-heading">
                                        <h3 class="card-title">Failers</h3>
                                    </div>
                                    <div  class="card-body">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                <th scope="col">Row Number</th>
                                                <th scope="col">Field</th>
                                                <th scope="col">Error</th>
                                                <th scope="col">Value</th>
                                                </tr>
                                            </thead>
                                            @foreach(session()->get('failures') as $validation)
                                            <tbody>
                                            <tr>
                                                <th scope="row">{{ $validation->row() }}</th>
                                                <td>{{ $validation->attribute() }}</td>
                                                <td>
                                                <ul>
                                                    @foreach($validation->errors() as $error )
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                </td>
                                                <td>{{ isset($validation->values()[$validation->attribute()]) ? $validation->values()[$validation->attribute()] : '' }}</td>
                                            </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </div>
                                    </div> 
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function unlock(){
    document.getElementById('buttonSubmit').removeAttribute("disabled");
}

</script>
@endsection
