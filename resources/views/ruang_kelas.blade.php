@extends('layouts.app')

@section('header')
<h1 class="fw-bold">Ruang Kelas</h1>
@endsection
 
@section('content')

<div class="modal fade" tabindex="-1" id="modalTambahRuangKelas" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Mata Pelajaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formTambahRuangKelas" acion="">
            @csrf
            <div class="mb-3">
                <label for="">Nama Mata Pelajaran : </label>
                <input type="text" name="ruang_kelas" placeholder="Nama mata pelajaran" class="form-control">
                <div hidden id="validation_nama" class="text-danger">

                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="buttonTambahRuangKelas" class="btn btn-primary">Tambah</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="modalEditRuangKelas" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Mata Pelajaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form_edit_ruang_kelas" action="">
            @csrf
            <div class="mb-3">
                <label for="">Nama Mata Pelajaran : </label>
                <input type="text" name="nama" placeholder="Nama mata pelajaran" class="form-control">
                <div hidden id="validation_edit_nama" class="text-danger">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input hidden type="text" id="ruang_kelas" name="id">
            <button type="submit" id="button_edit_ruangKelas" class="btn btn-primary">Edit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        </div>
        </form>
      </div>
    </div>
</div>

<div class="bg-white w-100 rounded border p-4">
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambahRuangKelas" >Tambah Mata Pelajaran <i class="bi bi-plus"></i></button>
    <table class="table table-bordered w-100" id="table_ruang_kelas">
        <thead class="bg-primary">
                <td width="5%">No</td>
                <td>Ruang Kelas</td>
                <td>Owner</td>
                <td width="5%">Aksi</td>
        </thead>
        <tbody></tbody>
    </table>

</div>
@endsection

@section('js')
<x-script /> 
<script>
        const ruang_kelas = $("#table_ruang_kelas").DataTable({
            ajax: "{{ route('get_ruang_kelas') }}",
            responsive: true,
            columns: [
                { data: 'DT_RowIndex', class: 'text-center' },
                { data: 'nama' },
                { data: 'owner' },
                { data: 'aksi' }
            ]
        });

    function editMapel(e){
        console.log($(e)[0]);
        const data = $(e).data('json')
        console.log("🚀 ~ file: mapel.blade.php ~ line 100 ~ editMapel ~ data", data)
        $("#modalEditMapel").modal('show')
        $("#modalEditMapel").on('shown.bs.modal', () => {

            // initialize
            $("input[name='nama']").val(data.nama)
            $("#id_mapel").val(data.id)
            $("#preview_foto_guru").prop('src', `{{ url('image/guru/${data.profile}') }}`)

            // submit handler
            $("#button_edit_guru").off().on('click', (e) => {
                console.log("submit");
                const formData = new FormData($("#form_edit_guru")[0])
                $.ajax({
                    type: 'post',
                    method: 'post',
                    url: "{{ route('edit_mapel') }}",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: (res) => {
                        console.log("🚀 ~ file: mapel.blade.php ~ line 87 ~ $ ~ res", res)
                        if(res.status){
                            table_mapel.ajax.reload()
                            $("#modalEditMapel").modal('hide')
                            toastr.success(res.message)
                        }else{
                            toastr.error(res.message)
                            Object.keys(res.messages).forEach((value, key) => {
                                $(`*[name=${value}]`).addClass('is-invalid')
                                $(`#validation_edit_${value}`).html(res.messages[value])
                                $(`#validation_edit_${value}`).prop('hidden', false)                               
                            })
                        }
                    },
                    error: (res) => {
                        $('#button_edit_mapel').prop('disabled', false);
                        console.log(res);
                    },
                    complete: () => {
                        $('#button_edit_mapel').prop('disabled', false);
                    }
                })
                $('#button_edit_mapel').prop('disabled', true);
            })
        })
    }
    function deleteMapel(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: "Anda yakin ingin menghapus data ini?",
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "tidak",
            confirmButtonColor: '#ff4444',
            iconColor: '#ff4444',
        }).then((e) => {
            if(e.isConfirmed){
                $.ajax({
                    type:'get',
                    method: 'get',
                    url:`{{ url('mapel/${id}/delete') }}`,
                    success:(res) => {
                        if(res.status){
                            toastr.success(res.message)
                            table_mapel.ajax.reload()
                        }else{
                            toastr.error(res.message)
                        }
                    }
                })
            }
        })
    }
    $(document).ready(() => {
        console.log("HI");

        $('#role_input').select2()

        $("#modalTambahMapel").on('shown.bs.modal', () => {
            $("#formTambahMapel").off().one('submit',(e) => {
                e.preventDefault()
                console.log('submit');
                const formData = new FormData($("#formTambahMapel")[0])
                $('#buttonTambahMapel').prop('disabled', true);

                $.ajax({
                    type: 'post',
                    method: 'post',
                    url: "{{ route('tambah_mapel') }}",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: (res) => {
                        $('#buttonTambahMapel').prop('disabled', false);
                        console.log("🚀 ~ file: mapel.blade.php ~ line 87 ~ $ ~ res", res)
                        if(res.status){
                            toastr.success(res.message)
                            $("#formTambahMapel").trigger('reset')
                            table_mapel.ajax.reload()
                        }else{
                            toastr.error(res.message)
                            Object.keys(res.messages).forEach((value, key) => {
                                $(`*[name=${value}]`).addClass('is-invalid')
                                console.log($(`#validation_${value}`));
                                $(`#validation_${value}`).html(res.messages[value])
                                $(`#validation_${value}`).prop('hidden', false)                               
                            })
                        }
                    },
                    error: (res) => {
                        $('#buttonTambahMapel').prop('disabled', false);

                        console.log(res);
                    }
                })

            })  
        })

    })
</script>
@endsection

