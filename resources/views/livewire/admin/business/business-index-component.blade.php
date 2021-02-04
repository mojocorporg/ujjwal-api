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

                <!-- /.tag Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $module }} Table</h3>
                                <a href="{{ route('business.create') }}" class="btn btn-flat btn-secondary float-right"> <i
                                        class="fas fa-plus"></i> New {{ $module }}</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Company Name</th>
                                            <th>Owner Name</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($businesses as $business)
                                            <tr>
                                                <td>{{ $business->id }}</td>
                                                <td>{{ $business->company_name }}</td>
                                                <td>{{ $business->owner_name }}</td>
                                                <td>{{ $business->address }}</td>
                                                {{-- <td>{{ \Carbon\Carbon::parse($business->created_at)->format('d-m-Y') }} --}}
                                                </td>
                                                @if ($business->status == 1)
                                                    <td><span class="tag tag-success">Active</span></td>
                                                @else
                                                    <td><span class="tag tag-success">Inactive</span></td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('business.edit', ['business' => $business->id]) }}"
                                                        class="btn btn-sm btn-flat btn-primary"><i class="fa fa-eye"
                                                            aria-hidden="true"></i></a>
                                                    <a wire:click.prevent="destroy({{ $business->id }})"
                                                        onclick="confirm('Are you sure want to delete this business?') || event.stopImmediatePropagation()"
                                                        class="btn btn-sm btn-flat btn-danger"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $businesses->links() }}
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
