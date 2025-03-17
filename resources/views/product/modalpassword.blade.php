@extends('sidebar.app')


<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts')

        <div class="content" style=" padding: 20px;">
            <div class="container">
                <h3 align="center" class="mt-1">Generate Password</h3>

                <div class="row">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-12">
                        <div class="form-area">
                            <form method="POST" action="{{ route('admin.modal-password.store') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="modalpassword" id="modalpassword"
                                        placeholder="Password" required>
                                    <button type="button" id="generatePasswordCode"
                                        class="btn btn-success">Generate</button>
                                </div>
                                <button type="submit" id="savePasswordCode" class="btn btn-primary">Save</button>
                            </form>


                        </div>

                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Password</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="codeTable">
                                @foreach ($codes as $code)
                                    <tr>
                                        <td>{{ $code->layaway_code }}</td>
                                        <td>
                                            <span class="{{ $code->Iseen == 0 ? 'badge bg-primary' : 'badge bg-danger' }}">
                                                {{ $code->Iseen == 0 ? 'Available' : 'Expired' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    @endsection
    @push('css')
        <style>
            .form-area {
                padding: 20px;
                margin-top: 20px;
                background-color: #F1F0E8;
            }

            ul {
                list-style: none;
            }
        </style>
    @endpush
    @push('js')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("generatePasswordCode").addEventListener("click", function() {
                    let characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                    let password = "";

                    for (let i = 0; i < 6; i++) {
                        password += characters.charAt(Math.floor(Math.random() * characters.length));
                    }

                    let inputField = document.getElementById("modalpassword");
                    if (inputField) {
                        inputField.value = password;
                    } else {
                        console.error("Input field not found!");
                    }
                });
            });
        </script>
    @endpush
