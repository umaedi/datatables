<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" >
    <link href="{{ asset('css/offcanvas.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <script>let BaseUrl = "{{ url('/') }}";</script>
    <title>Laravel DataTable</title>
</head>

<body>
    <main role="main" class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded box-shadow">
          <div class="lh-100">
            <h6 class="mb-0 text-white lh-100">Laravel x datatable</h6>
            <small>Bootstrap v4</small>
          </div>
        </div>
        <table class="table table-bordered" id="users-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>    
    </div>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(function() {
           let table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: BaseUrl+'/api/user',
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                    "render": function ( data, type, row ) {
                    return `<button id="delete" data-id="`+ row.id +`" type="button" class="btn btn-sm btn-danger">Delete</button>` }
                }
                ]
            });
            $('#users-table tbody').on( 'click', '#delete', function () {
            let id = $(this).data('id');
		    remove(id); 
        });
        function remove(id){
            swal({
                title: "",
                text: "Hapus user ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: BaseUrl+'/api/destroy/'+id,
                        method: 'POST',
                        processData: false,
                        contentType: false,
                        cache: false,
                        complete: (response) => {
                            if(response.status == 200) {
                                table.ajax.reload();
                            }else {
                                console.log('gagal');
                            }
                        }
                        });
                        swal("User berhasil di hapus", {
                        icon: "success",
                    });
                }
                });
        }

        setInterval(() => {
            table.ajax.reload();
        }, 30000);

    });
    </script>
</body>

</html>