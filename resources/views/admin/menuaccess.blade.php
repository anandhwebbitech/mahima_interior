@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header">
            <h5>Role Menu Access</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('roleaccesssave') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Select Role</label>
                    <select name="role_id" id="role_id" class="form-control" required>
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            data-menus='{{ $role->menus }}'>
                            {{ $role->role_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="card">
                    <div class="card-header">
                        <strong>Sidebar Menus</strong>
                    </div>
                    <div class="card-body">
                        @foreach($menus as $menu)
                        <div class="form-check mb-2">
                            <input type="checkbox"
                                name="menu_ids[]"
                                value="{{ $menu->id }}"
                                class="form-check-input menu-checkbox"
                                id="menu{{ $menu->id }}">
                            <label class="form-check-label ms-2" for="menu{{ $menu->id }}">
                                {{ $menu->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <button class="btn btn-success mt-3">Save Access</button>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')

<script>
    alert(3);
    document.getElementById('role_id').addEventListener('change', function() {

        // Uncheck all first
        document.querySelectorAll('.menu-checkbox').forEach(cb => cb.checked = false);

        let selectedOption = this.options[this.selectedIndex];
        let menus = selectedOption.getAttribute('data-menus');

        if (menus) {
            let menuArray = JSON.parse(menus);

            document.querySelectorAll('.menu-checkbox').forEach(cb => {
                if (menuArray.includes(parseInt(cb.value))) {
                    cb.checked = true;
                }
            });
        }
    });
</script>
@endpush