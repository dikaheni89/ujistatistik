@extends('admin.theme.index')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/plugins/select2/select2.min.css') }}">
@endpush
@section('title', $title)
@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form class="form-vertical" action="{{ route('admin.datasets.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="control-label">Judul<label class="text-danger">*</label> :</label>
                            <input type="text" name="title" class="form-control" placeholder="Masukkan Judul" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Deskripsi :</label>
                            <textarea class="form-control" name="description" placeholder="Beberapa catatan berguna tentang data" rows="4"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Tags :</label>
                            <select class="form-control tagging" name="tags[]" multiple="multiple">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag }}">{{ $tag }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Licensi<label class="text-danger">*</label> :</label>
                            <select class="form-control select2" name="licence" required>
                                <option value="">Pilih Lisensi</option>
                                @foreach ($licenses as $license)
                                    <option value="{{ $license->title }}">{{ $license->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Organisasi<label class="text-danger">*</label> :</label>
                            <select class="form-control select2" name="organisation" required>
                                @foreach ($organisations as $organisation)
                                    <option value="{{ $organisation->id }}">{{ $organisation->organisation_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Visibility<label class="text-danger">*</label> :</label>
                            <select class="form-control" name="private" required>
                                <option value="0">Public</option>
                                <option value="1">Private</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Source :</label>
                            <input type="text" name="url" class="form-control"
                                placeholder="http://example.com/dataset.json">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Versi :</label>
                            <input type="text" name="version" class="form-control" placeholder="1.0">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Author :</label>
                            <input type="text" name="author" class="form-control" placeholder="Joe Bloggs">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Author Email :</label>
                            <input type="email" name="author_email" class="form-control" placeholder="joebloggs@mail.com">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Maintainer :</label>
                            <input type="text" name="maintainer" class="form-control" placeholder="Joe Bloggs">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Maintainer Email :</label>
                            <input type="email" name="maintainer_email" class="form-control"
                                placeholder="joebloggs@mail.com">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Custom Field :</label>
                            <table class="table table-bordered" id="tablecreate">
                                <colgroup>
                                    <col width="45%">
                                    <col width="45%">
                                    <col width="10%">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group mt-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Key</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="custom_field_key[]">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mt-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Value</span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        name="custom_field_value[]">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="actiontd">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-danger font-weight-bold hps mr-1"
                                                    style="display:none">X</button>
                                                <button type="button"
                                                    class="btn btn-primary font-weight-bold add ml-1">Tambah</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('theme/plugins/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            //
            $(".tagging").select2({
                tags: true,
                'placeholder': 'Contoh: Dishub, Pemkot, dll',
            });
            //
            $('.add').on('click', function() {
                let elm = $('#tablecreate tr:first').clone();
                elm.find('.actiontd .add').remove();
                elm.find('.actiontd .hps').show();
                elm.find('input').val('');
                $(elm).insertAfter('#tablecreate tr:first');
            });
            $('#tablecreate').on('click', '.hps', function() {
                let parent = $(this).parent().parent().parent().remove();
            });
        });
    </script>
@endpush
