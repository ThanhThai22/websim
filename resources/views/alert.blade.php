@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('error'))
    <script>
        swal("Bad error!", "{{ Session::get('error') }}!", "error");
    </script>
@endif

@if (Session::has('success'))
    <script>
        swal("Complete!", "{{ Session::get('success') }}!", "success");
    </script>
@endif
