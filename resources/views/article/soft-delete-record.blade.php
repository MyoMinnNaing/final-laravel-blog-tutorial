@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class=" text-center py-3 text-primary">Soft Deleted Records</h2>
        {{--
        @if (request()->has('view_deleted'))
            <a href="" class="btn btn-info">View All Users</a>
            <a href="" class="btn btn-success">Restore All</a>
        @else
            <a href="" class="btn btn-primary">View
                Delete Records</a>
        @endif --}}
        <div class=" d-flex justify-content-between">
            <a href="{{ route('article.index') }}" class=" btn btn-outline-primary">View All Articles</a>

            @if (App\Models\Article::onlyTrashed()->count() != 0)
                <a href="{{ route('soft-deleted-records.restore.all') }}" class=" btn btn-outline-success ">Retore All
                    Articles</a>
            @endif





        </div>
        <table class=" table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Article</th>
                    <th>Category</th>
                    @can('admin-only')
                        <th>Owner</th>
                    @endcan
                    <th>Control</th>
                    <th>Updated At</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($deletedArticles as $deletedArticle)
                    <tr class="">
                        <td>{{ $deletedArticle->id }}</td>
                        <td>
                            <div class=" d-flex">
                                @if ($deletedArticle->thumbnail)
                                    <img class=" rounded list-thumbnail me-2"
                                        src="{{ asset(Storage::url($deletedArticle->thumbnail)) }}" width="50"
                                        height="50" alt="">
                                @else
                                    <img class=" rounded list-thumbnail me-2"
                                        src="https://raw.githubusercontent.com/julien-gargot/images-placeholder/master/placeholder-square.png"
                                        alt="">
                                @endif
                                <div class="">
                                    {{ Str::words($deletedArticle->title, 5) }}
                                    <br>
                                    <span class=" small text-black-50">
                                        {{ Str::limit($deletedArticle->description, 30, '...') }}
                                    </span>
                                </div>
                            </div>

                        </td>
                        <td>
                            {{ $deletedArticle->category->title ?? 'Unkown' }}
                        </td>

                        @can('admin-only')
                            <td>{{ $deletedArticle->user->name }}</td>
                        @endcan
                        <td>
                            <div class="btn-group">
                                <a class=" btn btn-sm btn-outline-dark"
                                    href="{{ route('soft-deleted-record-detail.show', $deletedArticle->id) }}">
                                    <i class=" bi bi-info"></i>
                                </a>

                                {{-- @cannot('article-update', $article)
                                <button onclick="alert(`U don't have permission to do this`)"
                                    class="btn btn-sm btn-outline-dark">
                                    <i class=" bi bi-pencil"></i>
                                </button>
                            @endcannot --}}

                                @can('delete', $deletedArticle)
                                    <button form="aritcleDeleteFrom{{ $deletedArticle->id }}"
                                        class=" btn btn-sm btn-outline-dark">
                                        <i class=" bi bi-trash3"></i>
                                    </button>
                                @endcan

                                @if ($deletedArticle->trashed())
                                    <a href="{{ route('soft-deleted-records.restore', [$deletedArticle->id, 'restore' => 'true']) }}"
                                        class=" btn btn-sm btn-outline-dark">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                @endif


                            </div>
                            <form id="aritcleDeleteFrom{{ $deletedArticle->id }}" class=" d-inline-block"
                                action="{{ $deletedArticle->trashed() ? route('force-deleted-record', $deletedArticle->id) : '' }}"
                                method="post">
                                @method('delete')
                                @csrf

                            </form>

                        </td>
                        <td>
                            <p class=" small mb-0">
                                <i class=" bi bi-clock"></i>

                                {{ $deletedArticle->updated_at->format('h:i a') }}
                            </p>
                            <p class=" small mb-0">
                                <i class=" bi bi-calendar"></i>
                                {{ $deletedArticle->updated_at->format('d M Y') }}
                            </p>

                        </td>
                        <td>
                            <p class=" small mb-0">
                                <i class=" bi bi-clock"></i>

                                {{ $deletedArticle->created_at->format('h:i a') }}
                            </p>
                            <p class=" small mb-0">
                                <i class=" bi bi-calendar"></i>
                                {{ $deletedArticle->created_at->format('d M Y') }}
                            </p>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class=" text-center">
                            <h3 class=" py-3 text-primary">
                                There is no deleted records
                            </h3>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="">
        </div>
    @endsection
