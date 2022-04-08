@extends('layouts.app')

@section('content')
    @php /** @var \App\Models\BlogCategory $item */ @endphp

    @if($item->exists)
    <form method="POST" action="{{ route('blog.admin.categories.update', $item->id) }}">
    @method('PUT')
        @else
            <form method="POST" action="{{ route('blog.admin.categories.store')}}">
    @endif
    @csrf
    <div class="container">
        @php
            /** @var \Illuminate\Support\ViewErrorBag @errors */
        @endphp
       @include('blog.admin.category.includes.item_messeges')
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('blog.admin.category.includes.item_edit_main_col')
            </div>
            <div class="col-md-3">
                @include('blog.admin.category.includes.item_edit_add_col')
            </div>
        </div>
    </div>
    </form>


@endsection

