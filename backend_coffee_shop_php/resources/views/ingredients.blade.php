<x-layout title="Ingredients Page" name_page="page-ingredients">
    <div class="cont-table">
        <table class="table table-bordered table-sm" data-bs-theme="dark">
            <thead>
                <tr>
                    <th scope="col" class="th-id text-capitalize"> {{ __('t.id') ?? "id" }} </th>
                    <th scope="col" class="th-name text-capitalize"> {{ __('t.name') ?? "name" }} </th>
                    <th scope="col" class="th-unit text-capitalize"> {{ __('t.unit') ?? "unit" }} </th>
                    <th scope="col" class="th-stock text-capitalize"> {{ __('t.stock') ?? "stock" }} </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($ingredients as $in)
                    <tr>
                        <th scope="row" class="px-2">{{ $in->id }}</th>
                        <td class="px-2 text-capitalize">{{ $in->name }}</td>
                        <td class="px-2 text-capitalize">{{ $in->unit }}</td>
                        <td class="px-2">{{ $in->stock }} <small class="text-capitalize opacity-50">{{ $in->unit }}</small> </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</x-layout>
