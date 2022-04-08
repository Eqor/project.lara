@extends('layouts.app')

@section('content')
    @php /** @var \App\Models\BlogPost $item */ @endphp

    @if($item->exists)
        <form method="POST" action="{{ route('blog.admin.posts.update', $item->id) }}">
            @method('PUT')

            @else
                <form method="POST" action="{{ route('blog.admin.posts.store')}}">
                    @endif
                    @csrf
                    <div class="container">
                        @php
                            /** @var \Illuminate\Support\ViewErrorBag @errors */
                        @endphp

                        @include('blog.admin.post.includes.item_messeges')

                        <div class="row justify-content-center">
                            <div class="col-md-7">
                                @include('blog.admin.post.includes.item_edit_main_col')
                            </div>
                            <div class="col-md-3">
                                @include('blog.admin.post.includes.item_edit_add_col')
                            </div>
                        </div>
                    </div>
                </form>
                @if($item->exists)
                    <br>
                    <form method="POST" action="{{ route('blog.admin.posts.destroy', $item->id) }}">
                        @method('DELETE')
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body ml-auto">
                                        <button type="submit" class="btn btn-link">Удалить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                    </div>


@endsection

