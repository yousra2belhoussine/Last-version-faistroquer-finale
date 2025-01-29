@extends('layouts.app')

@section('content')
    <div class="bg-[#a3cca8]/10">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-[#157e74] sm:text-5xl">Toutes les catégories</h1>
                <p class="mt-4 text-xl text-[#6dbaaf]">Explorez toutes nos catégories d'échange</p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($categories as $category)
                    <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 overflow-hidden">
                        <div class="relative w-full h-48 bg-gradient-to-br from-[#6dbaaf]/20 to-[#a3cca8]/20 group-hover:scale-105 transition-transform duration-200">
                            @if($category->icon)
                                <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="w-full h-full object-center object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-4xl text-[#157e74] group-hover:scale-110 transition-transform duration-200">
                                        {{ substr($category->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-[#157e74] group-hover:text-[#279078] transition-colors duration-200">
                                <a href="{{ route('categories.show', $category) }}" class="hover:underline">
                                    <span class="absolute inset-0"></span>
                                    {{ $category->name }}
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-[#6dbaaf]">{{ $category->ads_count ?? 0 }} annonces</p>
                            <p class="mt-4 text-sm text-[#6dbaaf] line-clamp-2">
                                {{ $category->description ?? 'Découvrez les annonces dans cette catégorie.' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection 