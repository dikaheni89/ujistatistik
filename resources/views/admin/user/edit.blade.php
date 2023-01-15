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
                    <form class="form-vertical" action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label class="control-label">Organisasi<label class="text-danger">*</label> :</label>
                            <select class="form-control" name="organisation" id="Organisation" required>
                                <option value="">Pilih Organisasi</option>
                                @foreach ($organisations as $organisation)
                                    <option value="{{ $organisation->id }}" @selected($organisation->id == $user->organisation_id)>
                                        {{ $organisation->organisation_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Nama<label class="text-danger">*</label> :</label>
                            <input type="text" name="name" id="Nama"
                                value="{{ $user->organisations->organisation_name }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Email<label class="text-danger">*</label> :</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                placeholder="example@gmail.com" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label">Password<label class="text-danger">*</label> :</label>
                            <input type="password" name="password" class="form-control" placeholder="*******">
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
            $('#Organisation').select2({
                placeholder: 'Pilih Organisasi',
            });
            //
            $('#Organisation').on('change', function() {
                var data = $("#Organisation option:selected").text().trim();
                $("#Nama").val(data);
            })
        });
    </script>
@endpush
