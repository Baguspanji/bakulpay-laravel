@extends('layouts.app')

@section('title', 'BakulPay | Customer Management')

@section('content')
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
        </button>
    </div>

    <div class="container">
        <h2>Customer Managements</h2>

        @foreach ($admins as $admin)
            <div class="data-customer">
                <div class="data-cs">
                    <div class="data-cs_1">ID {{ $admin->id }}</div>
                    <div class="data-cs_2">
                        @if ($admin->active === true || strtolower($admin->active) === 'true')
                            <span class="active-status">Active</span>
                        @else
                            <span class="inactive-status">No Active</span>
                        @endif
                    </div>
                    <div class="data-cs_3">
                        <a
                            href="{{ $admin->active === 'false' ? route('deactivate_customer', ['id' => $admin->id]) : route('activate_customer', ['id' => $admin->id]) }}">
                            <iconify-icon class="{{ $admin->active === 'false' ? 'blue-icon' : 'red-icon' }}"
                                icon="{{ $admin->active === 'false' ? 'ic:outline-toggle-on' : 'ic:outline-toggle-off' }}"></iconify-icon>
                        </a>
                    </div>
                </div>
                <hr class="hr_cs">
                <div class="data-cs">
                    <div>
                        @if ($admin->photo)
                            <img src="{{ asset($admin->photo) }}" alt="Customer Photo">
                        @else
                            <p>No photo available</p>
                        @endif
                    </div>
                    <div class="data-cs_4">
                        <div class="data-cs_5">{{ $admin->name }}</div>
                        <div class="data-cs_6">{{ $admin->email }}</div>
                    </div>

                    <div class="data-cs_7">{{ $totals[$admin->id]['overall'] }}</div>
                    <div class="data-cs_8">transaction</div>
                </div>
                {{-- hidden --}}
                <hr class="hr_cs">
                <div class="data-cs_13">
                    <div class="data-cs_9">Whatsapp number</div>
                    <div class="data-cs_10">{{ $admin->noHp }}</div>
                    <div class="data-cs_9">Email Address</div>
                    <div class="data-cs_11">{{ $admin->email }}</div>
                </div>

                <div class="data-cs_12">
                    <div class="data-cs_14">{{ $totals[$admin->id]['overall'] }}</div>
                    <div class="data-cs_14">{{ $totals[$admin->id]['success'] }}</div>
                    <div class="data-cs_14">{{ $totals[$admin->id]['pending'] }}</div>
                    <div class="data-cs_14">{{ $totals[$admin->id]['failed'] }}</div>
                </div>

                <div class="data-cs_15">
                    <div class="data-cs_16">In Total</div>
                    <div class="data-cs_16">Success</div>
                    <div class="data-cs_16">Pending</div>
                    <div class="data-cs_16">Failed</div>
                </div>

                {{-- akhir hidden --}}

            </div>
        @endforeach

    </div>

@endsection
