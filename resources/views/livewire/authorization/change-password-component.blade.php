<div>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Change Password</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
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
                    <!-- /.Create Tag  -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                        <h3 class="card-title">Change password</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form wire:submit.prevent="update">
                                    <div class="card-body animated fadeIn delay-1s">
                                        <div class="form-group col-md-6">
                                            <label for="old_password">Old Password </label>
                                            <input type="text" wire:model.lazy="old_password"
                                                class="form-control @error('old_password') is-invalid @enderror"
                                                name="old_password" value="{{ old('old_password') }}" autocomplete="old_password" autofocus
                                                id="old_password" placeholder="Enter Old Password">
                                            @error('old_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="new_password">New Password </label>
                                            <input type="text" wire:model.lazy="new_password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                name="new_password" value="{{ old('new_password') }}" autocomplete="new_password" autofocus
                                                id="new_password" placeholder="Enter New Password ">
                                            @error('new_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="confirm_password">Confirm Password </label>
                                            <input type="text" wire:model.lazy="confirm_password"
                                                class="form-control @error('tag.confirm_password') is-invalid @enderror"
                                                name="confirm_password" value="{{ old('confirm_password') }}" autocomplete="confirm_password" autofocus
                                                id="confirm_password" placeholder="Confirm Password">
                                            @error('confirm_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right ml-2">Update</button>
                                        
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
