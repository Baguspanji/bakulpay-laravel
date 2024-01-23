@extends('layouts.app')

@section('title', 'BakulPay | Bank Withdraw')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Bank Withdraw</h2>
        <a class="add {{ Request::is('form_bankwd*') ? 'active' : '' }}" href="{{ url('/form_bankwd') }}" role="button">+ Add
            New</a>
        <div class="isi">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Bank</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bank_wd_data as $data)
                        <tr>
                            <td class="ikon">
                                <img src="{{ $data->icons }}" alt="Bank Icon">
                            </td>
                            <td>{{ $data->nama_bank }}</td>
                            <td>
                                <a class="btn {{ Request::is('edit-bankwd*') ? 'active' : '' }}"
                                    href="{{ route('edit_bankwd', ['id' => $data->id]) }}">
                                    <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                </a>
                                <a class="btn"
                                    href="{{ $data->active === 'false' ? route('deactivate_bankwd', ['id' => $data->id]) : route('activate_bankwd', ['id' => $data->id]) }}">
                                    <iconify-icon class="{{ $data->active === 'false' ? 'blue-icon' : 'red-icon' }}"
                                        icon="{{ $data->active === 'false' ? 'ic:outline-toggle-on' : 'ic:outline-toggle-off' }}"></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
