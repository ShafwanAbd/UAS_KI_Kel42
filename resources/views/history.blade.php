@extends('layouts.layout_main')

@section('content')
<div class="visible-print text-center">
    {!! QrCode::size(500)->generate(Request::url()); !!} 
</div>
@endsection
