@extends('base')

@section('title', $title)

@section('content')

<div class="text-end"> 
    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-primary">{{ __('Posts') }}</a>
</div>

{!! form($form) !!}

@endsection