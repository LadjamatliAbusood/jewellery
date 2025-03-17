@extends('admin.admin') <!-- Extends the base admin layout -->

<body style="background-color:#f8f9fa;">
    @section('content')
        <!-- Defines the content section -->


        <div class="container mt-5 text-center">
            <h1>Export Database</h1>
            <p>Click the button below to download the database backup.</p>
            <a href="{{ route('export.database') }}" class="btn btn-success">Download Database</a>
        </div>
    @endsection
</body>
