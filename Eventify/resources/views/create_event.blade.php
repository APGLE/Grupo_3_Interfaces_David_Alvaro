@extends('layouts.app')

@section('content')
    <div id="app">
        <create-event-component></create-event-component>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endsection
