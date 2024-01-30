@extends('layouts.app')

@section('title', 'BakulPay | Dashboard')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>
    <div class="container_1">
        <div class="data-container">
            <div class="data-item">
                <div class="data-isi">125</div>
                <div class="data-keterangan">View More<iconify-icon icon="maki:arrow"></iconify-icon></div>
            </div>
            <div class="data-item">
                <div class="data-isi">125</div>
                <div class="data-keterangan">View More<iconify-icon icon="maki:arrow"></iconify-icon></div>
            </div>
            <div class="data-item">
            </div>
        </div>
        <div class="data-container">
            <div class="data-item_1">
                <h5>Transactions</h5>
                <div class="isi">
                    <!-- Tabel -->
                    <table id="myTable" class="display">
                        <!-- Header Tabel -->
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Number Whatsapp</th>
                                <th>Customer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <!-- Body Tabel -->
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a class="btn" href="#">
                                        <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
