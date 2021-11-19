@extends('layouts.frontend-master')

@section('title',(__('header.news')) )

@section('page-content')
    <!-- Page Content  -->
    <main class="content list-news-page">
        <div class="container">
            <div class="row">
                @if($news->count())
                    @foreach($news as $news_obj)
                        @include('news.news-card',compact('news_obj'))
                    @endforeach
                @endif
            </div>
        </div>
    </main>
@endsection