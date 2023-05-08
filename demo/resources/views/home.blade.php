@extends('layouts.app')

@section('content')

    <body>
        <div id="login">
            <h3 class="text-center text-dark pt-5">Login form</h3>
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="" method="post">
                                <h3 class="text-center text-info">Country state</h3>
                                <div class="form-group">
                                    <label for="city" class="text-info">City:</label><br>
                                    <select name="city[]" id="city" class="form-control" multiple="multiple">
                                        <option value="AL">Alabama</option>
                                        <option value="WY">Wyoming</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-secondary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#city').select2();
            });
        </script>
    </body>
@endsection
