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
                @if (isset($show_form) && $show_form)
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
                                        <div class="form-group col-md-6">
                                            <label for="name">Name </label>
                                            <input type="text" wire:model="tag.name"
                                                class="form-control @error('tag.name') is-invalid @enderror"
                                                name="name" value="{{ old('name') }}" autocomplete="name" autofocus
                                                id="name" placeholder="Enter Name Of Tag">
                                            @error('tag.name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label for="status">Status</label>
                                            <br>
                                            <input type="checkbox" wire:model="tag.status" name="status"
                                                data-bootstrap-switch data-off-color="danger" data-on-color="success">
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
                @endif

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

                <!-- /.tag Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $module }} Table</h3>
                                <button wire:click="toggleForm" class="btn btn-flat btn-secondary float-right"> <i
                                        class="fas fa-plus"></i> New {{ $module }}</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tags as $tag)
                                            <tr>
                                                <td>{{ $tag->id }}</td>
                                                <td>{{ $tag->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($tag->created_at)->format('d-m-Y') }}
                                                </td>
                                                @if ($tag->status == 1)
                                                    <td><span class="tag tag-success">Active</span></td>
                                                @else
                                                    <td><span class="tag tag-success">Inactive</span></td>
                                                @endif
                                                <td>
                                                    <a wire:click="edit({{ $tag }})"
                                                        class="btn btn-sm btn-flat btn-primary"><i class="fa fa-eye"
                                                            aria-hidden="true"></i></a>
                                                    <a wire:click.prevent="destroy({{ $tag->id }})"
                                                        onclick="confirm('Are you sure want to delete this tag?') || event.stopImmediatePropagation()"
                                                        class="btn btn-sm btn-flat btn-danger"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $tags->links() }}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.Tag Table -->
            </div>
        </section>
    </div>
</div>
