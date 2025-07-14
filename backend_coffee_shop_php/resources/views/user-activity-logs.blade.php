
<x-layout title="User Activity Logs Page" name_page="page-user-activity-logs">

    <x-only-admin>

        <div class="box-title d-flex justify-content-end mb-3" data-bs-theme="dark">
            <form method="get">
                <div class="d-flex input-group-sm gap-2">
                    <input class="form-control" type="text" value="{{ request('search') }}" name="search" id="search"
                        placeholder="{{ __('t.search') ?? 'search' }}">
                    <button class="btn btn-sm btn-primary px-3"> {{ __('t.search') ?? 'search' }} </button>
                </div>
            </form>
        </div>

        @if ($logs->count() > 0)
            <div class="cont-table">
                <table class="table table-bordered table-sm" data-bs-theme="dark">
                    <thead>
                        <tr>
                            <th scope="col" class="th-name text-capitalize">{{ __('t.name') ?? "name" }}</th>
                            <th scope="col" class="th-login text-capitalize">{{ __('t.login') ?? "login" }}</th>
                            <th scope="col" class="th-logout text-capitalize">{{ __('t.logout') ?? "logout" }}</th>
                            <th scope="col" class="th-os text-capitalize">{{ __('t.os') ?? "os" }}</th>
                            <th scope="col" class="th-device text-capitalize">{{ __('t.device') ?? "device" }}</th>
                            <th scope="col" class="th-browser text-capitalize">{{ __('t.browser') ?? "browser" }}</th>
                            <th scope="col" class="th-ip-address text-capitalize">{{ __('t.ip_address') ?? "ip_address" }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($logs as $log)
                            <tr>
                                <td class="px-2">{{ $log->user->name }}</td>
                                <td class="px-2 ltr">{{ $log->login_at }}</td>
                                <td class="px-2 ltr">{{ $log->logout_at ?? '*' }}</td>
                                <td class="px-2 ltr">{{ $log->os }}</td>
                                <td class="px-2 ltr">{{ $log->device }}</td>
                                <td class="px-2 ltr">{{ $log->browser }}</td>
                                <td class="px-2 ltr">{{ $log->ip_address }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{ $logs->links() }}
        @else
            <div class="alert alert-secondary mt-3 text-capitalize" role="alert">
                {{ __('t.no_data_found') ?? 'No data found.' }}
            </div>
        @endif

    </x-only-admin>

</x-layout>


{{-- <x-swal class_form=".form-delete-review"></x-swal> --}}
