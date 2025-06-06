<x-layout title="update category Page" name_page="page-update-category container mt-3">

    <div class="box">
        <button class="back" onclick="history.back()">
            <x-icon name="arrow_back" />
        </button>
        <h2 class="text-light">Update category</h2>
    </div>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" data-bs-theme="dark">
        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{ $category->id }}">

        <div class="mb-3 mt-4 input-group-sm">
            <label for="name" class="form-label text-light mb-2">Name</label>
            <input type="text" class="form-control" value="{{ old('name', $category->name) }}" id="name"
                placeholder="Enter Name" name="name">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="price" class="form-label text-light mb-2">icon</label>
            <input type="text" class="form-control" id="price" placeholder="Enter Icon code" name="icon"
                value="{{ old('icon', $category->icon) }}">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="price" class="form-label text-light mb-2">index</label>
            <input type="text" class="form-control" id="price" placeholder="Enter Index" name="index"
                value="{{ old('index', $category->index) }}">
        </div>

        <div class="input-group-sm d-grid">
            <button type="submit" class="btn btn-primary mt-2">Update category</button>
        </div>

    </form>

</x-layout>
