
@extends('admin_layout.admin')

@section('title')
    Add Role
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Role</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add role</small></h3>
                            </div>

                            @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all(); as $error)
                                            <li>{{$error}}</li>

                                            @endforeach
                                        </ul>

                                    </div>
                            @endif

                            @if (Session::has('status'))
                                    <div class="alert alert-success">
                                        {{Session::get('status')}}
                                    </div>
                            @endif
                            <!-- /.card-header -->
                            <!-- form start -->
                            {{-- <form> --}}

                                {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>{{ __('Nom') }}:</strong>
                                            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th>Models</th>
                                                @foreach ($operations as $item)
                                                    <th>{{ $item }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($models as $object)
                                                <input type="hidden" name="models[]" value="{{ $object }}">
                                                <tr>
                                                    <td>{{ $object }}</td>
                                                    @foreach ($operations as $operation)
                                                        <input type="hidden" name="operators{{ $object }}[]"
                                                            value="{{ $operation }}">
                                                        <td>
                                                            <input type="hidden" name="id{{ $object . $operation }}"
                                                                value="{{ $class->checkPermission($object, $operation, $role->id) }}">
                                                            <input type="checkbox" name="permissions{{ $object . $operation }}"
                                                                @if ($class->checkPermission($object, $operation, $role->id) > 0) checked @endif>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button type="submit" class="btn btn-warning">{{ __('Modifier') }}</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}

                <!--</form>-->
            </div>
            <!-- /.card -->
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-6">

    </div>
    <!--/.col (right) -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <!-- jquery-validation -->
    <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>



    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->

    <script src="../../dist/js/demo.js"></script>
    <script>
        $(function() {
            $.validator.setDefaults({
                submitHandler: function() {
                    alert("Form successful submitted!");
                }
            });
            $('#quickForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    terms: {
                        required: true
                    },
                },
                messages: {
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    terms: "Please accept our terms"
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
