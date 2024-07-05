@extends('layouts.admin')

@section('title', 'Pegawai')
@section('page-title', 'Pegawai')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                {{-- Datatables --}}
                <div class="col-sm-12">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalPegawai">Tambah Pegawai</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="pegawaiTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>E-mail</th>
                                    <th>Jabatan</th>
                                    <th>Gaji</th>
                                    <th>Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Datatables End --}}
            </div>
        </div>

        {{-- Modal --}}
        <div class="modal fade" id="modalPegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-pegawai">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form theme-form">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Nama Lengkap</label>
                                                    <input class="form-control" type="text" placeholder="Nama Lengkap"
                                                        name="nama_lengkap" id="nama_lengkap" required="required" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Alamat</label>
                                                    <textarea id="alamat" class="form-control" id="exampleFormControlTextarea4" rows="3" name="alamat"
                                                        placeholder="Alamat" required="required"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Telepon</label>
                                                    <input class="form-control" type="text" placeholder="Telepon"
                                                        name="telepon" id="telepon" required="required" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>E-mail</label>
                                                    <input class="form-control" type="email" placeholder="E-mail"
                                                        name="email" id="email" required="required" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Jabatan</label>
                                                    <input class="form-control" type="text" placeholder="Jabatan"
                                                        name="jabatan" id="jabatan" required="required" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Gaji</label>
                                                    <input class="form-control" type="number" placeholder="Gaji"
                                                        name="gaji" id="gaji" required="required" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label>Upload Photo</label>
                                                    <div class="upload__box">
                                                        <div class="upload__btn-box">
                                                            <input 
                                                                type="file" 
                                                                name="photo"
                                                                data-max_lenght="20" 
                                                                class="upload__inputfile"
                                                                id="fileUpload" 
                                                                hidden 
                                                                required="required"
                                                            >
                                                            <label for="fileUpload" class="label-file">Choose File</label>
                                                        </div>
                                                        <div class="text-center w-100">
                                                            <div class="upload__img-wrap"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" id="btnSubmit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Modal End --}}
    </div>
@endsection

@push('addon-script')
    <script>
        var isEdit = false;
        var tempId = null;
        const actualBtn = document.getElementById('fileUpload');

        jQuery(document).ready(function() {
            ImgUpload();
            var pegawaiTable = $('#pegawaiTable').DataTable({
                dom: '<"row justify-content-between"<"col-lg-4 align-self-center"l><"col-lg-4 align-self-center"f>>1<"table-responsive"tr><"row justify-content-between mt-3"<"col-lg-4 align-self-center"i><"col-lg-8 align-self-center"p>>',
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                },
                columns: [{
                        data: null,
                        width: '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nama_lengkap',
                        render(data) {
                            return '<span class="font-weight-bold text-primary">' + data +
                                '</span>'
                        }
                    },
                    {
                        data: 'alamat',
                    },
                    {
                        data: 'telepon',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'jabatan',
                    },
                    {
                        data: 'gaji',
                    },
                    {
                        data: 'photo',
                        render: function(data, type, row, meta) {
                            let img =
                                // `<img src="{{ asset('storage') }}/${data}" class="img-fluid" style="width: 50px;"></img>`
                                `<a href="{{ asset('storage') }}/${data}" target="_blank">Lihat Gambar</a>`
                            return img
                        }
                    },
                    {
                        data: 'id',
                        width: '5%',
                        render: renderAction
                    }
                ]
            });

            function renderAction(data, type, row, meta) {
                let btn = ` <ul class="action" style="list-style: none;">
                                <li class="edit"> <button type="button" class="bg-transparent btnEdit btn" data-id="${data}" data-id="${row.id}" data-nama_lengkap="${row.nama_lengkap}" data-alamat="${row.alamat}" data-telepon="${row.telepon}" data-email="${row.email}" data-jabatan="${row.jabatan}" data-gaji="${row.gaji}" data-photo="${row.photo}"><i class="icon-pencil-alt"></i></button></li>
                                <li class="delete"><button type="button" class="bg-transparent btn btnDeleteDt" data-url="{{ route('pegawai.destroy', '') }}/${data}"><i class="icon-trash"></i></button></li>
                            </ul>`
                return btn
            }
        });

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            $('.upload__inputfile').each(function() {
                $(this).on('change', function(e) {
                    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                    var maxLength = $(this).attr('data-max_length');

                    var files = e.target.files;
                    var filesArr = Array.prototype.slice.call(files);
                    var iterator = 0;
                    filesArr.forEach(function(f, index) {

                        if (!f.type.match('image.*')) {
                            return;
                        }

                        if (imgArray.length > maxLength) {
                            return false
                        } else {
                            var len = 0;
                            for (var i = 0; i < imgArray.length; i++) {
                                if (imgArray[i] !== undefined) {
                                    len++;
                                }
                            }
                            if (len > maxLength) {
                                return false;
                            } else {
                                imgArray.push(f);

                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    var html =
                                        "<div class='upload__img-box'><div style='background-image: url(" +
                                        e.target.result + ")' data-number='" + $(
                                            ".upload__img-close").length + "' data-file='" + f
                                        .name +
                                        "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                    imgWrap.append(html);
                                    iterator++;
                                }
                                reader.readAsDataURL(f);
                            }
                        }
                    });
                });
            });

            $('body').on('click', ".upload__img-close", function(e) {
                var file = $(this).parent().data("file");
                for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i].name === file) {
                        imgArray.splice(i, 1);
                        break;
                    }
                }
                $(this).parent().parent().remove();
            });
        }

        function handleCreateData() {
            $('button').prop('disabled', true)
            let btnText = $('#btnSubmit').html()
            $('#btnSubmit').html('<i class="fa fa-spinner fa-spin" ></i> Loading')

            let formData = new FormData($('#form-pegawai')[0])
            $.ajax({
                type: "POST",
                url: "{{ route('pegawai.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#modalPegawai').modal('hide')
                    $('#btnSubmit').html(btnText)
                    $('#form-pegawai')[0].reset()
                    $('#pegawaiTable').DataTable().ajax.reload()
                    $('button').prop('disabled', false)
                },
                error: function(err) {
                    $('#btnSubmit').html(btnText)
                    $('button').prop('disabled', false)
                }
            });
        }

        function handleEditData() {
            $('button').prop('disabled', true)
            let btnText = $('#btnSubmit').html()
            $('#btnSubmit').html('<i class="fa fa-spinner fa-spin" ></i> Loading')

            let formData = new FormData($('#form-pegawai')[0])
            formData.append('id', tempId)
            $.ajax({
                type: "POST",
                url: "{{ route('pegawai.update') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    console.log('success: ',res)
                    $('#modalPegawai').modal('hide')
                    $('#btnSubmit').html(btnText)
                    $('#form-pegawai')[0].reset()
                    $('#pegawaiTable').DataTable().ajax.reload()
                    $('button').prop('disabled', false)
                },
                error: function(err) {
                    console.log('error: ',err)
                    $('#btnSubmit').html(btnText)
                    $('button').prop('disabled', false)
                }
            });
        }
        $('#form-pegawai').submit(function(e) {
            e.preventDefault()
            if (isEdit) {
                handleEditData()
            } else {
                handleCreateData()
            }
        })

        $('body').delegate('.btnEdit', 'click', function() {
            isEdit = true;
            tempId = $(this).data('id')
            let id = $(this).data('id')
            let nama_lengkap = $(this).data('nama_lengkap')
            let alamat = $(this).data('alamat')
            let telepon = $(this).data('telepon')
            let email = $(this).data('email')
            let jabatan = $(this).data('jabatan')
            let gaji = $(this).data('gaji')
            let photo = $(this).data('photo')

            $('#fileUpload').removeAttr('required')
            $('#modalPegawai').modal('show')
            $('#id').val(id)
            $('#nama_lengkap').val(nama_lengkap)
            $('#alamat').val(alamat)
            $('#telepon').val(telepon)
            $('#email').val(email)
            $('#jabatan').val(jabatan)
            $('#gaji').val(gaji)
            $('#photo').val('')

        })
    </script>
@endpush
