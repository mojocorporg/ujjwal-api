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
                                                <label for="title">Title </label>
                                                <input type="text" wire:model.lazy="notification.title"
                                                    class="form-control @error('notification.title') is-invalid @enderror"
                                                    name="title" value="{{ old('title') }}" autocomplete="title" autofocus
                                                    id="title" placeholder="Enter Notification Title">
                                                @error('notification.title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
        
                                            <div class="form-group col-md-12">
                                                <label for="body">Body </label>
                                                <input type="text" wire:model.lazy="notification.body"
                                                    class="form-control @error('notification.body') is-invalid @enderror"
                                                    name="body" value="{{ old('body') }}" autocomplete="body" autofocus
                                                    id="body" placeholder="Enter Notification Body">
                                                @error('notification.body')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="icon">Image </label>
                                                <input type="text" wire:model.lazy="icon"
                                                    class="form-control @error('icon') is-invalid @enderror"
                                                    name="icon" value="{{ old('icon') }}" autocomplete="icon" autofocus
                                                    id="icon" >
                                                @error('notification.icon')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
        
                                            <div class="form-group col-md-12">
                                                <label for="address">Notification Type </label>
                                                <select  name="notification.repeat_type" wire:model="notification.repeat_type" class="form-control @error('notification.repeat_type') is-invalid @enderror select2" multiple="multiple" style="width: 100%;" >
                                                    <option >Select Notification Type </option>
                                                    @foreach ($repeat_types as $key => $type)
                                                        <option value="{{ $type['key'] }}">{{ $type['value'] }}</option>
                                                    @endforeach
                                                </select>
                                                @error('notification.repeat_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="pincode">Pincode </label>
                                                <input type="text" wire:model.lazy="notification.pincode"
                                                    class="form-control @error('notification.pincode') is-invalid @enderror"
                                                    name="pincode" value="{{ old('pincode') }}" autocomplete="pincode" autofocus
                                                    id="pincode" placeholder="Enter Company Pincode">
                                                @error('notification.pincode')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="address">State </label>
                                                <input type="text" wire:model.lazy="notification.address"
                                                    class="form-control @error('notification.address') is-invalid @enderror"
                                                    name="address" value="{{ old('address') }}" autocomplete="address" autofocus
                                                    id="address" placeholder="Enter Company Address">
                                                @error('notification.address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="city">City </label>
                                                <input type="text" wire:model.lazy="notification.city"
                                                    class="form-control @error('notification.city') is-invalid @enderror"
                                                    name="city" value="{{ old('city') }}" autocomplete="city" autofocus
                                                    id="city" placeholder="Enter Company city">
                                                @error('notification.city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="description">description </label>
                                                <textarea wire:model.lazy="notification.description"
                                                    class="form-control @error('notification.description') is-invalid @enderror"
                                                    name="description" value="{{ old('description') }}" autocomplete="description" autofocus
                                                    id="description" placeholder="Enter Company description"></textarea>
                                                @error('notification.description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="status">Status</label>
                                                <br>
                                                <input type="checkbox" wire:model="notification.status" name="status"
                                                    data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                            </div>
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
