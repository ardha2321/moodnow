@extends('layouts.app')
@section('title', 'User MoodNow')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Users MoodNow</h1>
    </div>

    <div class="section-body">

        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-users"></i> Users MoodNow</h4>
            </div>

            <div class="card-body">
                <form action="#" method="GET">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="q"
                                    placeholder="cari berdasarkan nama user">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col" style="text-align: center;width: 6%">NO.</th>
                            <th scope="col">USERNAME</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col" style="width: 15%;text-align: center">CREATED AT</th>
                            <th scope="col" style="width: 15%;text-align: center">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $no => $user)
                            @if ($user->getRoleNames()->contains('user'))
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td style="text-align: center">{{ $user->created_at }}</td>
                                    <td class="text-center">
                                        @can('users.edit')
                                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('users.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $user->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: center">
                        {{$users->links("vendor.pagination.bootstrap-5")}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>  

<script>
    //ajax delete
    function Delete(id)
        {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    //ajax delete
                    jQuery.ajax({
                        url: "{{ route("admin.user.index") }}/"+id,
                        data:   {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }else{
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }
</script>
@stop