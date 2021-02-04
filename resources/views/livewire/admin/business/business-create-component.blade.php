<div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Manage {{ $module }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Manage {{ $module }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- /.Create Tag  -->
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                @if ($updateMode)
                                    <h3 class="card-title">Edit {{ $module }}</h3>
                                @else
                                    <h3 class="card-title">Create {{ $module }}</h3>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form wire:submit.prevent="store">
                                <div class="card-body animated fadeIn delay-1s">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group col-md-12">
                                                <label for="company_name">Company Name </label>
                                                <input type="text" wire:model.lazy="business.company_name"
                                                    class="form-control @error('business.company_name') is-invalid @enderror"
                                                    name="company_name" value="{{ old('company_name') }}" autocomplete="company_name" autofocus
                                                    id="company_name" placeholder="Enter Name Of Company">
                                                @error('business.company_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
        
                                            <div class="form-group col-md-12">
                                                <label for="owner_name">Owner Name </label>
                                                <input type="text" wire:model.lazy="business.owner_name"
                                                    class="form-control @error('business.owner_name') is-invalid @enderror"
                                                    name="owner_name" value="{{ old('owner_name') }}" autocomplete="owner_name" autofocus
                                                    id="owner_name" placeholder="Enter Company Owner Name">
                                                @error('business.owner_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
        
                                            <div class="form-group col-md-12">
                                                <label for="address">Address </label>
                                                <input type="text" wire:model.lazy="business.address"
                                                    class="form-control @error('business.address') is-invalid @enderror"
                                                    name="address" value="{{ old('address') }}" autocomplete="address" autofocus
                                                    id="address" placeholder="Enter Company Address">
                                                @error('business.address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
        
        
                                            <div class="form-group col-md-12">
                                                <label for="lat">Latitude </label>
                                                <input type="text" wire:model.lazy="business.lat"
                                                    class="form-control @error('business.lat') is-invalid @enderror"
                                                    name="lat" value="{{ old('lat') }}" autocomplete="lat" autofocus
                                                    id="lat" placeholder="Enter Latitude">
                                                @error('business.lat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
        
                                            <div class="form-group col-md-12">
                                                <label for="long">Longitude </label>
                                                <input type="text" wire:model.lazy="business.long"
                                                    class="form-control @error('business.long') is-invalid @enderror"
                                                    name="long" value="{{ old('long') }}" autocomplete="long" autofocus
                                                    id="long" placeholder="Enter Longitude">
                                                @error('business.long')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            

                                            <div class="form-group col-md-12">
                                                <label for="description">description </label>
                                                <textarea wire:model.lazy="business.description"
                                                    class="form-control @error('business.description') is-invalid @enderror"
                                                    name="description" value="{{ old('description') }}" autocomplete="description" autofocus
                                                    id="description" placeholder="Enter Company description"></textarea>
                                                @error('business.description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="status">Status</label>
                                                <br>
                                                <input type="checkbox" wire:model="business.status" name="status"
                                                    data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <table id="myTable" class=" table order-list">
                                                <thead>
                                                    <tr>
                                                        <td>Contact</td>
                                                        <td><a wire:click="addRow" class="btn btn-success btn-sm">Add</a> </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($contacts as $key => $contact)
                                                    <tr>
                                                        <td class="col-md-4">
                                                            <input type="number" wire:model="contacts.{{$key}}" class="form-control" />
                                                        </td>
                                                        <td class="col-md-2">
                                                            <a  wire:click="removeRow({{$key}})" class="btn btn-danger btn-sm">Delete</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @if($updateMode)
                                    <button type="submit" class="btn btn-primary float-right ml-2">Update</button>
                                    @else
                                    <button type="submit" class="btn btn-primary float-right ml-2">Submit</button>
                                    @endif
                                    <a wire:click="toggleForm" class="btn btn-success float-right ml-2">Cancel</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
