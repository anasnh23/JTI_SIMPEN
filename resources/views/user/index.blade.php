    @extends('layouts.template')

    @section('content')
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $page->title }}</h3>
                <div class="card-tools">
                    <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-info">Impor User</button>
                    <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Data</button>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-1 control-label col-form-label">Filter: </label>
                            <div class="col-3">
                                <select class="form-control" id="level_id" name="level_id" required>
                                    <option value="">- Semua -</option>
                                    @foreach ($level as $item)
                                        <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Level Pengguna</small>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Level</th>
                            <th>user</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    @endsection

    @push('css')
    @endpush

    @push('js')
        <script>
            function modalAction(url = '') {
                $('#myModal').load(url, function() {
                    $('#myModal').modal('show');
                });
            }

            var dataUser;
            $(document).ready(function() {
                dataUser = $('#table_user').DataTable({
                    serverSide: true,
                    ajax: {
                        "url": "{{ url('user/list') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function(d) {
                            d.level_id = $('#level_id').val();
                            d._token = "{{ csrf_token() }}"; // Menambahkan token CSRF
                        },
                        "error": function(xhr, status, error) {
                            console.log(xhr.responseText);  // Menampilkan error jika ada masalah
                        }
                    },
                    columns: [
                        {
                            data: "DT_RowIndex",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "username",
                            className: "",
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: "level.level_nama",
                            className: "",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "aksi",
                            className: "",
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // Filter berdasarkan level
                $('#level_id').on('change', function() {
                    dataUser.ajax.reload();
                });
            });
        </script>
    @endpush