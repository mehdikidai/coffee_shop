<x-layout title="product edit Page" name_page="page-product-edit container mt-3">


    <div class="box">
        <button class="back" id="btn_back_edit_product" onclick="history.back()">
            <x-icon name="arrow_back" />
        </button>
        <h2 class="text-light text-capitalize"> {{ __('t.update_user') ?? "update user" }} </h2>
    </div>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
        data-bs-theme="dark">
        @csrf
        @method('PUT')

        <div class="mb-3 mt-4 input-group-sm">
            <label for="name" class="form-label text-light mb-2 text-capitalize"> {{ __('t.name') ?? "name" }}
            </label>
            <input type="text" class="form-control" value="{{ old('name', $user->name) }}" id="name"
                placeholder="Enter Name" name="name">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="email" class="form-label text-light mb-2 text-capitalize"> {{ __('t.email') ?? "email" }} </label>
            <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email"
                value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="exampleFormControlInput1" class="form-label text-light mb-2 text-capitalize">
                {{ __('t.password') ?? "password" }} </label>
            <input type="password" name="password" class="form-control" placeholder="password">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="table" class="form-label text-light mb-2 text-capitalize">{{ __('t.table') ?? "table" }} </label>
            <input type="text" class="form-control" id="email" placeholder="Enter table" name="table_number"
                value="{{ old('table_number', $user->table_number) }}">
        </div>

        <div class="mb-3 input-group-sm">
            <label for="category_id" class="form-label text-light text-capitalize"> {{ __('t.role') ?? "role" }} </label>
            <select class="form-select" name="role" aria-label="Default select example">
                @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 input-group-sm">
            <label for="formFile" class="form-label text-light text-capitalize"> {{ __('t.photo') ?? "photo" }} </label>
            <input class="form-control" name="photo" type="file">
            <small class="text-muted"> {{ __('t.leave_blank_to_keep_current_photo') ?? "leave blank to keep current photo" }} </small>
        </div>

        <div class="input-group-sm d-grid">
            <button type="submit" class="btn btn-primary mt-2 text-capitalize"> {{ __('t.update_user') ?? "update_user" }} </button>
        </div>



    </form>

</x-layout>
