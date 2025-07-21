@extends('components.layouts.app')

@section('content')
    @include('components.partial.header')
    @include('components.partial.hero')
    @include('components.partial.about')
    @include('components.partial.menu')
    @include('components.partial.chefs')
    @include('components.partial.book')
    @include('components.partial.events')
    @include('components.partial.location')
    @include('components.partial.contact')


    <livewire:booking-form />

    @include('components.partial.footer')
@endsection
