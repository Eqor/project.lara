@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <table class="table table-hover">
                    <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                        <a class="btn btn-primary" href="{{route('blog.admin.categories.create')}}">Добавить</a>
                    </nav>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Категория</th>
                        <th>Родитель</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($paginator as $item)
                        @php /** @var \App\Models\BlogCategory $item */ @endphp
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <a href="{{ route('blog.admin.categories.edit', $item->id) }}">
                                    {{ $item->title }}
                                </a>
                            </td>
                            <td @if(in_array($item->parent_id,[0,1])) style="{{ asset('css/app.css') }} " @endif>

                                {{$item->parent_id}}{{--$item->parentCategory->title --}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
