<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title')</title>

    <link rel="icon" href="../assets/images/nyar.png" sizes="16x16" type="image/png">
    <link rel="icon" href="../assets/images/nyar.png" sizes="32x32" type="image/png">


    <!-- Bootstrap CSS CDN -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    {{-- ok --}}

    <!-- Our Custom CSS -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    <!-- Add this to your HTML -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}"">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>


    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>

    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script> --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>


    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script> --}}

    <!-- jQuery Custom Scroller CDN -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "dom": '<"top"lf>rt<"bottom"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search...",
                },
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
            });

            // Add search icon
            $('.dataTables_filter input').attr('placeholder', 'Search');
            $('.dataTables_filter label').append(
                '<iconify-icon icon="ic:round-search" class="search-icon"></iconify-icon>');
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "dom": '<"top"lf>rt<"bottom"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search...",
                },
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
            });

            // Add search icon
            $('.dataTables_filter input').attr('placeholder', 'Search');
            $('.dataTables_filter label').append(
                '<iconify-icon icon="ic:round-search" class="search-icon"></iconify-icon>');

            // Custom filter for Bank Name (replace 3 with your Bank Name column index)
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var selectedBank = $('#bank-filter').val();
                    var bankName = data[3]; // Assuming Bank Name is in the fourth column (adjust as needed)

                    if (selectedBank === '' || selectedBank === bankName) {
                        return true;
                    }

                    return false;
                }
            );

            // Custom filter for Status (replace 1 with your Status column index)
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var selectedStatus = $('#status-filter').val();
                    var status = data[1]; // Assuming Status is in the second column (adjust as needed)

                    if (selectedStatus === '' || selectedStatus === status) {
                        return true;
                    }

                    return false;
                }
            );

            // Apply custom filters on select change
            $('#bank-filter, #status-filter').on('change', function() {
                $('#myTable').DataTable().draw();
            });
        });
    </script>


    @stack('script')

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('assets/images/logo bakulpay.png') }}" alt="Logo BakulPay">
            </div>
            <hr>

            <ul class="list-unstyled components">

                <li class="{{ Request::is('/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><iconify-icon
                            icon="material-symbols:dashboard"></iconify-icon>Dashboard</a>
                </li>

                <li
                    class="{{ Request::is('payment*') || Request::is('top-up*') || Request::is('withdraw*') || Request::is('form_payment*') || Request::is('edit_payment*') || Request::is('edit_topup*') || Request::is('edit_withdraw*') ? 'active' : '' }}">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                        <iconify-icon icon="uil:transaction"></iconify-icon>
                        Transaction
                        <span class="arrow-icon"><iconify-icon icon="fe:arrow-down"></iconify-icon></span>
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li
                            class="{{ Request::is('payment*') || Request::is('form_payment*') || Request::is('edit_payment*') ? 'active' : '' }}">
                            <a href="{{ route('payment') }}"><iconify-icon
                                    icon="material-symbols:payments"></iconify-icon>Payment</a>
                        </li>

                        <li class="{{ Request::is('top-up*') || Request::is('edit_topup*') ? 'active' : '' }}">
                            <a href="{{ route('topup') }}"><iconify-icon
                                    icon="majesticons:money-plus-line"></iconify-icon>Top-Up</a>
                        </li>

                        <li class="{{ Request::is('withdraw*') || Request::is('edit_withdraw*') ? 'active' : '' }}">
                            <a href="{{ route('withdraw') }}"><iconify-icon
                                    icon="majesticons:money-plus-line"></iconify-icon>Withdraw</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::is('wallet') ? 'active' : '' }}">
                    <a href="{{ route('wallet') }}"><iconify-icon icon="solar:wallet-bold"></iconify-icon>Wallet</a>
                </li>

                <li
                    class="{{ Request::is('bank_wd*') || Request::is('transactionmd*') || Request::is('pay_md*') || Request::is('form_transactionmd*') || Request::is('edit-transactionmd*') || Request::is('form_paymentmd*') || Request::is('edit-paymentmd*') || Request::is('form_bankwd*') || Request::is('edit-bankwd*') ? 'active' : '' }}">
                    <a href="#MDSubmenu" data-toggle="collapse" aria-expanded="false">
                        <iconify-icon icon="tdesign:data"></iconify-icon>
                        Master Data
                        <span class="arrow-icon"><iconify-icon icon="fe:arrow-down"></iconify-icon></span>
                    </a>
                    <ul class="collapse list-unstyled" id="MDSubmenu">
                        <li
                            class="{{ Request::is('transactionmd*') || Request::is('form_transactionmd*') || Request::is('edit-transactionmd*') ? 'active' : '' }}">
                            <a href="{{ route('transactionmd') }}"><iconify-icon
                                    icon="fa6-solid:money-bill"></iconify-icon>Transaction MD</a>
                        </li>
                        <li
                            class="{{ Request::is('pay_md*') || Request::is('form_paymentmd*') || Request::is('edit-paymentmd*') ? 'active' : '' }}">
                            <a href="{{ route('pay_md') }}"><iconify-icon
                                    icon="material-symbols:payments"></iconify-icon>Payment MD</a>
                        </li>
                        <li
                            class="{{ Request::is('bank_wd*') || Request::is('form_bankwd*') || Request::is('edit-bankwd*') ? 'active' : '' }}">
                            <a href="{{ route('bank_wd') }}"><iconify-icon
                                    icon="material-symbols:payments"></iconify-icon>Withdraw MD</a>
                        </li>
                    </ul>
                </li>

                <li
                    class="{{ Request::is('rate*') || Request::is('cs_management*') || Request::is('edit-rate*') ? 'active' : '' }}">
                    <a href="#SettingsSubmenu" data-toggle="collapse" aria-expanded="false">
                        <iconify-icon icon="lets-icons:setting-fill"></iconify-icon>
                        Settings
                        <span class="arrow-icon"><iconify-icon icon="fe:arrow-down"></iconify-icon></span>
                    </a>
                    <ul class="collapse list-unstyled" id="SettingsSubmenu">
                        <li class="{{ Request::is('rate*') || Request::is('edit-rate*') ? 'active' : '' }}">
                            <a href="{{ route('rate') }}"><iconify-icon
                                    icon="fa6-solid:money-bill"></iconify-icon>Rate</a>
                        </li>
                        <li class="{{ Request::is('cs_management*') ? 'active' : '' }}">
                            <a href="{{ route('cs_management') }}"><iconify-icon
                                    icon="mdi:user-outline"></iconify-icon>Customer
                                Management</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            @yield('content')
        </div>
</body>

</html>
