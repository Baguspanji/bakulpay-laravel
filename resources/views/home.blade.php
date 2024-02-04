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
            {{-- <div class="data-item">
                <div class="data-isi">
                    <div class="data-cont1">{{ $totalPending }}</div>
                    <div class="data-cont2">New Order</div>
                    <div><img src="{{ asset('assets/images/rate_naik.png') }}" alt="Image Alt Text"></div>
                    <div class="data-keterangan">View More<iconify-icon icon="maki:arrow"></iconify-icon></div>
                </div>
            </div> --}}

            <div class="data-item" id="dropdownContainer">
                <div class="data-isi" id="dropdownTrigger">
                    <div class="data-cont1">{{ $totalPending }}</div>
                    <div class="data-cont2">New Order</div>
                    <div><img src="{{ asset('assets/images/rate_naik.png') }}" alt="Image Alt Text"></div>
                    <div class="data-keterangan" id="viewMoreTrigger">
                        View More<iconify-icon icon="maki:arrow"></iconify-icon>
                    </div>
                </div>
                <div class="dropdown-content" id="dropdownContent">
                    <!-- Your dropdown content goes here -->
                    <a href="{{ route('topup') }}"><p>Top - Up</p></a>
                    <a href="{{ route('withdraw') }}"><p>Withdraw</p></a>
                </div>
            </div>

            <div class="data-item">
                <div class="data-isi">
                    <div class="data-cont1">{{ $totalNewUsers }}</div>
                    <div class="data-cont2">New Users</div>
                    <div><img src="{{ asset('assets/images/rate_turun.png') }}" alt="Image Alt Text"></div>
                    <a href="{{ route('cs_management') }}">
                        <div class="data-keterangan">View More<iconify-icon icon="maki:arrow"></iconify-icon></div>
                    </a>
                </div>

            </div>
            <div class="data-item">
                <div class="data-background">
                    <img src="{{ asset('assets/images/frame 89.png') }}" alt="Image Alt Text">
                    <div class="overlay-text">
                        <div class="overlay-text-1">My Balance</div>
                        <div class="overlay-text-2">$ {{ number_format($totalPembayaran / 14000, 0) }}</div>
                        <div class="overlay-text-2">IDR {{ number_format($totalPembayaran) }}</div>
                    </div>
                </div>
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
                            @foreach ($pendingTopups as $topup)
                                <tr>
                                    <td>{{ $topup->id }}</td>
                                    <td class="status-{{ strtolower(str_replace(' ', '-', $topup->status)) }}">
                                        <p class="stats">{{ $topup->status }}</p>
                                    </td>
                                    <td>Top-Up</td>
                                    <td>{{ $topup->tanggal }}</td>
                                    <td>{{ $topup->admin ? $topup->admin->noHp : 'N/A' }}</td>
                                    <td>
                                        {{ $topup->admin ? $topup->admin->name : 'N/A' }}
                                    </td>
                                    <!-- Add other columns as needed -->
                                    <td>
                                        <a class="btn {{ Request::is('edit-topup*') ? 'active' : '' }}"
                                            href="{{ route('edit_topup', $topup->id) }}">
                                            <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach ($pendingWithdraws as $withdraw)
                                <tr>
                                    <td>{{ $withdraw->id }}</td>
                                    <td class="status-{{ strtolower(str_replace(' ', '-', $withdraw->status)) }}">
                                        <p class="stats">{{ $withdraw->status }}</p>
                                    </td>
                                    <td>Withdraw</td>
                                    <td>{{ $withdraw->tanggal }}</td>
                                    <td>{{ $withdraw->admin ? $withdraw->admin->noHp : 'N/A' }}</td>
                                    <td>
                                        {{ $withdraw->admin ? $withdraw->admin->name : 'N/A' }}
                                    </td>
                                    <!-- Add other columns as needed -->
                                    <td>
                                        <a class="btn {{ Request::is('edit-withdraw*') ? 'active' : '' }}"
                                            href="{{ route('edit_withdraw', $withdraw->id) }}">
                                            <iconify-icon icon="akar-icons:edit"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var dropdownTrigger = document.getElementById("viewMoreTrigger");
            var dropdownContent = document.getElementById("dropdownContent");

            dropdownTrigger.addEventListener("click", function() {
                dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" :
                    "block";
            });

            // Close the dropdown if the user clicks outside of it
            window.addEventListener("click", function(event) {
                if (event.target !== dropdownTrigger && event.target !== dropdownContent) {
                    dropdownContent.style.display = "none";
                }
            });
        });
    </script>

@endsection
