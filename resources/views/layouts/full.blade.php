@extends('merlion::layouts.html')

@section('content')
    @include('merlion::layouts.content', ['content' => $self->getContent()])
@endsection
