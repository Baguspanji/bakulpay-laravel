@extends('layouts.app')

@section('title', 'BakulPay | Payment MD')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Payment Master Data</h2>
        <a class="add {{ Request::is('form_paymentmd*') ? 'active' : '' }}" href="{{ url('/form_paymentmd') }}"
            role="button">+ Add New</a>
        <div class="isi">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Bank Name</th>
                        <th>No.Rek</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payment_master_data as $data)
                        <tr>
                            <td class="ikon">
                                <img src="{{ $data->icons }}" alt="Bank Icon">
                                <p>
                                    {{ $data->nama_bank }}</p>
                            </td>
                            <td>{{ $data->no_rekening }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>
                                <a class="btn {{ Request::is('edit-paymentmd*') ? 'active' : '' }}"
                                    href="{{ route('edit_paymentmd', ['id' => $data->id]) }}">
                                    <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                </a>

                                <a class="btn"
                                    href="{{ $data->active === 'false' ? route('deactivate_paymentmd', ['id' => $data->id]) : route('activate_paymentmd', ['id' => $data->id]) }}">
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
