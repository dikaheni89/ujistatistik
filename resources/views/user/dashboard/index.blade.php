@extends('user.theme.index')
@section('title', $title)
@push('styles')
    <link href="{{ asset('theme/assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')


@endsection
@push('scripts')
    <script src="{{ asset('theme/assets/js/dashboard/dash_1.js') }}"></script>
@endpush
