@extends('layouts.app')

@section('title', 'BakulPay | Transaction MD')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Transaction Master Data</h2>
        <a class="add {{ Request::is('form_transactionmd*') ? 'active' : '' }}" href="{{ url('/form_transactionmd') }}"
            role="button">+ Add New</a>
        <div class="isi">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Bank Name</th>
                        <th>Blockchain</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rate_master_data as $data)
                        @if (count($data->blockchains) > 0)
                            @foreach ($data->blockchains as $blockchain)
                                <tr>
                                    <td class="ikon">
                                        <img src="{{ $data->icons }}" alt="Bank Icon">
                                        <p>{{ $data->nama_bank }}</p>
                                    </td>
                                    <td>{{ $blockchain->nama_blockchain }}</td>
                                    <td>{{ $data->type }}</td>
                                    <td>
                                        <a class="btn {{ Request::is('edit-transactionmd/' . $data->id . '/' . $blockchain->id) ? 'active' : '' }}"
                                            href="{{ route('edit_transactionmd', ['id' => $data->id, 'blockchain_id' => $blockchain->nama_blockchain]) }}">
                                            <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                        </a>
                                        <a class="btn"
                                            href="{{ $blockchain->active === 'false' ? route('deactivate_blockchain', ['id' => $data->id, 'blockchain_id' => $blockchain->nama_blockchain]) : route('activate_blockchain', ['id' => $data->id, 'blockchain_id' => $blockchain->nama_blockchain]) }}">
                                            <iconify-icon
                                                class="{{ $blockchain->active === 'false' ? 'blue-icon' : 'red-icon' }}"
                                                icon="{{ $blockchain->active === 'false' ? 'ic:outline-toggle-on' : 'ic:outline-toggle-off' }}"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            {{-- Display a row with empty blockchain --}}
                            <tr>
                                <td class="ikon">
                                    <img src="{{ $data->icons }}" alt="Bank Icon">
                                    <p>{{ $data->nama_bank }}</p>
                                </td>
                                <td>-</td> {{-- Empty blockchain --}}
                                <td>{{ $data->type }}</td>
                                <td>
                                    <a class="btn {{ Request::is('edit-transactionmd/' . $data->id) ? 'active' : '' }}"
                                        href="{{ route('edit_transactionmd', ['id' => $data->id]) }}">
                                        <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                    </a>
                                    <a class="btn"
                                        href="{{ $data->active === 'false' ? route('deactivate_transactionmd', ['id' => $data->id]) : route('activate_transactionmd', ['id' => $data->id]) }}">
                                        <iconify-icon class="{{ $data->active === 'false' ? 'blue-icon' : 'red-icon' }}"
                                            icon="{{ $data->active === 'false' ? 'ic:outline-toggle-on' : 'ic:outline-toggle-off' }}"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @empty
                        {{-- Handle the case where $rate_master_data is empty --}}
                        <tr>
                            <td colspan="4">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
