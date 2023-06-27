@extends('layouts.app')
@section('content')
    <div class=" container">
        <div class="row">
            <div class="col-12">
                <h3>Article Detail</h3>
                <hr>

                <div class=" mb-3">
                    <a href="{{ route('article.create') }}" class="btn btn-outline-dark">Create</a>
                    <a href="{{ route('article.index') }}" class="btn btn-outline-dark">All Articles</a>
                </div>

                <img src="{{ asset(Storage::url($article->thumbnail)) }}" height="200" alt="">




                <div>
                    <h4>{{ $article->title }}</h4>
                    <div class="">
                        <span class=" badge bg-black">
                            {{ $article->category_id }}
                        </span>
                    </div>
                    <div class="">

                        {{ $article->description }}

                    </div>
                </div>



                @foreach ($article->photos as $photo)
                    <a class="venobox" data-gall="aa" data-maxwidth="600px"
                        href="{{ asset(Storage::url($photo->address)) }}">
                        <img src="{{ asset(Storage::url($photo->address)) }}" alt="image alt" />
                    </a>
                @endforeach


            </div>
        </div>
    </div>
@endsection


@push('script')
    @vite(['resources/js/venobox.js'])
@endpush
