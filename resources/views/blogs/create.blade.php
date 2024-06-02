@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="bg-green-200 text-green-700 p-4 mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-200 text-red-700 p-4 mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form id="blogForm" method="POST" action="{{ route('blogs.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="text-xl text-gray-600">Title <span class="text-red-500">*</span></label><br>
                        <input type="text" class="border-2 border-gray-300 p-2 w-full" name="title" id="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="text-xl text-gray-600">Description</label><br>
                        <input type="text" class="border-2 border-gray-300 p-2 w-full" name="description" id="description" placeholder="(Optional)" value="{{ old('description') }}">
                        @error('description')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="text-xl text-gray-600">Category <span class="text-red-500">*</span></label><br>
                        <select name="category_id" class="border-2 border-gray-300 p-2 w-full">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="text-xl text-gray-600">Tags</label><br>
                        <select name="tags[]" class="border-2 border-gray-300 p-2 w-full" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('tags')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label class="text-xl text-gray-600">Content <span class="text-red-500">*</span></label><br>
                        <textarea name="content" class="border-2 border-gray-500" id="content">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex p-1">
                        <select class="border-2 border-gray-300 border-r p-2" name="action">
                            <option value="Save and Publish">Save and Publish</option>
                            <option value="Save Draft">Save Draft</option>
                        </select>
                        <button type="submit" class="p-3 bg-blue-500 text-white hover:bg-blue-400">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
@endsection
