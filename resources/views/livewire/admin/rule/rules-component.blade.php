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
                                <h3 class="card-title">Update {{ $module }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form wire:submit.prevent="store">
                                <div class="card-body animated fadeIn delay-1s">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group col-md-12">
                                                <label for="without_login">Number of Businesses on without Login </label>
                                                <input type="text" wire:model.lazy="rule.without_login"
                                                    class="form-control @error('rule.without_login') is-invalid @enderror"
                                                    name="without_login" value="{{ old('without_login') }}" autocomplete="without_login" autofocus
                                                    id="without_login" placeholder="Number of Businesses Without login">
                                                @error('rule.without_login')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
        
                                            <div class="form-group col-md-12">
                                                <label for="with_login">Number of Businesses with Login </label>
                                                <input type="text" wire:model.lazy="rule.with_login"
                                                    class="form-control @error('rule.with_login') is-invalid @enderror"
                                                    name="with_login" value="{{ old('with_login') }}" autocomplete="with_login" autofocus
                                                    id="with_login" placeholder="Number of Businesses With login">
                                                @error('rule.with_login')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
        
                                            <div class="form-group col-md-12">
                                                <label for="on_referral">Number of Businesses on every Referral </label>
                                                <input type="text" wire:model.lazy="rule.on_referral"
                                                    class="form-control @error('rule.on_referral') is-invalid @enderror"
                                                    name="on_referral" value="{{ old('on_referral') }}" autocomplete="on_referral" autofocus
                                                    id="on_referral" placeholder="Number of Businesses Every Referral">
                                                @error('rule.on_referral')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <hr>
                                            <h5>Payment Module</h5>
                                            <br>
                                            <div class="form-group col-md-12">
                                                <label for="on_referral">Price (in Rs.) </label>
                                                <input type="text" wire:model.lazy="rule.price"
                                                    class="form-control @error('rule.price') is-invalid @enderror"
                                                    name="price" value="{{ old('price') }}" autocomplete="price" autofocus
                                                    id="price" placeholder="Price of the Paid package">
                                                @error('rule.on_referral')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="on_referral">Number of Businesses on Every Payment</label>
                                                <input type="text" wire:model.lazy="rule.on_payment"
                                                    class="form-control @error('rule.on_payment') is-invalid @enderror"
                                                    name="on_payment" value="{{ old('on_payment') }}" autocomplete="on_payment" autofocus
                                                    id="on_payment" placeholder="Number of Businesses on Every Payment">
                                                @error('rule.on_payment')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-right ml-2">Update</button>
                                    <a href="{{ route('home') }}" class="btn btn-success float-right ml-2">Cancel</a>
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
