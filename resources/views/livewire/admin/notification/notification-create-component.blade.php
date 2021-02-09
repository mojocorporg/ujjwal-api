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
                                                <input type="file" wire:model.lazy="icon"
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
                                                <select  name="notification.repeat_type" wire:model="notification.repeat_type" class="form-control @error('notification.repeat_type') is-invalid @enderror">
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



                                            @if($notification->repeat_type == 'once')
                                                <div class="form-group col-md-12">
                                                    <label for="schedule_date">Schedule Date </label>
                                                    <input type="date" wire:model.lazy="notification.schedule_date"
                                                        class="form-control @error('notification.schedule_date') is-invalid @enderror"
                                                        name="schedule_date" value="{{ old('schedule_date') }}" autocomplete="schedule_date" autofocus
                                                        id="schedule_date" placeholder="Enter Date To Schedule">
                                                    @error('notification.schedule_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            @endif
                                            @if($notification->repeat_type == 'every_day' || $notification->repeat_type == 'once' || $notification->repeat_type == 'custom_day')
                                                <div class="form-group col-md-12">
                                                    <label for="schedule_time">Time </label>
                                                    <input type="time" wire:model="notification.schedule_time"
                                                        class="form-control @error('notification.schedule_time') is-invalid @enderror"
                                                        name="schedule_time" value="{{ old('schedule_time') }}" autocomplete="schedule_time" autofocus
                                                        id="schedule_time" placeholder="Enter Date To Schedule">
                                                    @error('notification.schedule_time')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            @endif

                                            @if($notification->repeat_type == 'custom_day')
                                            <div class="form-group col-md-12">
                                                <label for="days">Days </label>
                                                @foreach ($days as $day)    
                                                    <div class="form-check">
                                                        <input wire:model="selected_days" value="{{ $day['key'] }}" class="form-check-input" type="checkbox">
                                                        <label class="form-check-label">{{ $day['value'] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @endif   

                                            <div class="form-group col-md-12">
                                                <label for="address">Section </label>
                                                <select  wire:model="notification.section" class="form-control @error('notification.section') is-invalid @enderror">
                                                    <option >Select Section </option>
                                                    @foreach ($sections as $key => $type)
                                                        <option value="{{ $type['key'] }}">{{ $type['value'] }}</option>
                                                    @endforeach
                                                </select>
                                                @error('notification.section')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            @if($notification->section == 'business' || $notification->section == 'user_profile')
                                            <div class="form-group col-md-12">
                                                <label for="section_id">Section ID </label>
                                                <input type="number" wire:model="notification.section_id"
                                                    class="form-control @error('notification.section_id') is-invalid @enderror"
                                                    name="section_id" value="{{ old('section_id') }}" autocomplete="section_id" autofocus
                                                    id="section_id" placeholder="Enter Section Id">
                                                @error('notification.section_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            @endif

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
