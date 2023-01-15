@extends('user.theme.index')
@section('title', $title)
@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form class="form-vertical" action="{{ route('test.store', $resource->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <span class="text-danger">
                                * Yang bertanda bintang wajib diisi
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Kode Kabupaten<label class="text-danger">*</label> :</label>
                            <input type="number" name="kode_kabupaten" class="form-control" placeholder="Kode Kabupaten"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Nama Kabupaten<label class="text-danger">*</label> :</label>
                            <input type="text" name="nama_kabupaten" class="form-control" placeholder="Nama Kabupaten"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Jenis Pajak Daerah :</label>
                            <input type="text" name="jenis_pajak_daerah" class="form-control" placeholder="Jenis Pajak">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Tahun<label class="text-danger">*</label> :</label>
                            @php
                                $year = date('Y');
                                $year = $year - 2;
                                for ($i = 0; $i < 5; $i++) {
                                    $years[] = $year + $i;
                                }
                                $years = array_reverse($years);
                            @endphp
                            <select name="tahun" class="form-control" required>
                                <option value="">Pilih Tahun</option>
                                @foreach ($years as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Jumlah Target :</label>
                            <input type="text" name="jumlah_target" class="form-control" placeholder="Jumlah Target">
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Satuan<label class="text-danger">*</label> :</label>
                            <input type="text" name="satuan" class="form-control" placeholder="Satuan" required>
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
