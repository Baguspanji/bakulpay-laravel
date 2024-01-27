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
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}""> --}}
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
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
        });
    </script>

    <script>
        body {
            font - family: "Poppins", sans - serif;
            background: #fafafa;
        }

        p {
            font - family: "Poppins", sans - serif;
            font - size: 1.1 em;
            font - weight: 300;
            line - height: 1.7 em;
            color: #999;
    }

    a,
    a:hover,
    a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    /* .navbar {
        padding: 15px 10px;
        background: # fff;
            border: none;
            border - radius: 0;
            margin - bottom: 40 px;
            box - shadow: 1 px 1 px 3 px rgba(0, 0, 0, 0.1);
        }

        .navbar - btn {
                box - shadow: none;
                outline: none!important;
                border: none;
            }

            .line {
                width: 100 % ;
                height: 1 px;
                border - bottom: 1 px dashed #ddd;
                margin: 40 px 0;
            }*/

            /* ---------------------------------------------------
            SIDEBAR STYLE
            ----------------------------------------------------- */

            .wrapper {
                display: flex;
                width: 100 % ;
                align - items: stretch;
            }

        #sidebar {
            min - width: 250 px;
            max - width: 250 px;
            background: #ffffff;
            color: #a8afbd;
            transition: all 0.3 s;
        }

        #sidebar.active {
            margin - left: -250 px;
        }

        #sidebar.sidebar - header {
            background: #ffffff;
            text - align: center;
        }

        #sidebar ul.components {
            padding: 20 px 0;
            border - bottom: 1 px solid #ffffff;
        }

        #sidebar ul.components li ul li a {
            text - align: center;
        }

        #sidebar ul.components li a {
            font - size: 0.8 em;
            display: flex;
            align - items: center;
            padding: 10 px;
            width: 90 % ;
            margin: 10 px auto;
            text - align: center;
        }

        #sidebar ul.components li ul li a {
            font - size: 0.8 em;
            margin: 5 px 15 px;
            border - radius: 20 px;
            padding: 8 px;
            width: calc(100 % -20 px);
        }

        #sidebar ul.components li ul {
            width: 98 % ;
            left: auto;
            right: 20 px;
        }

        #sidebar ul.components li ul li.active > a {
            color: #000000;
        background: # ffffff;
            border: 1 px solid #c2d7ff;
            font - size: 0.5 em;
            padding: 3 px;
        }

        #sidebar ul.components li.active > a iconify - icon {
            border: 1 px solid #007bff;
        background-color: # 007 bff;
            border - radius: 50 % ;
            padding: 3 px;
            color: white;
        }

        #sidebar ul.components li ul li.active > a iconify - icon {
                border: 1 px solid #ffffff;
                background - color: #ffffff;
                border - radius: 50 % ;
                padding: 3 px;
                color: #37398b;
    }

    # sidebar ul.components li.active > a.arrow - icon iconify - icon {
                    border: 1 px solid #ffffff;
                    background - color: #ffffff;
                    border - radius: 50 % ;
                    padding: 3 px;
                    color: rgb(0, 0, 0);
                }

                #sidebar ul li a {
                    font - size: 1 em;
                    display: flex;
                    align - items: center;
                    padding: 5 px;
                    width: 90 % ;
                    margin: 0 auto;
                    text - align: center;
                }

                #sidebar ul li a iconify - icon {
                    margin - right: 10 px;
                    font - size: 1.5 em;
                }

                #sidebar ul li a: hover,
                #sidebar ul li.active > a,
                a[aria - expanded = "true"] {
                    color: #000000;
        background: # dcf5ff;
                    font - weight: bold;
                    border - radius: 20 px;
                    width: 90 % ;
                }

                a[data - toggle = "collapse"] {
                    position: relative;
                }

                /* #sidebar ul.components li a[data-toggle="collapse"] .arrow-icon {
                    transition: transform 0.5s;
                    transform-origin: center center;
                    margin-right: 10px;
                } */

                #sidebar ul.components li a[data - toggle = "collapse"].arrow - icon {
                    display: inline - block;
                    margin - left: auto; /* Menempatkan ikon di sebelah kanan */
                }

                #sidebar ul.components li a[data - toggle = "collapse"].arrow - icon::before {
                    font - family: "Font Awesome 5 Free";
                    margin - left: 10 px; /* Sesuaikan jarak sesuai kebutuhan */
                    transition: transform 0.5 s;
                    transform - origin: center center;
                }

                #sidebar
                ul.components
                li
                a[data - toggle = "collapse"][aria - expanded = "true"]
                .arrow - icon {
                    transform: rotate(180 deg);
                }

                /* test */
                /* .dropdown-toggle::after {
                    display: block;
                    position: absolute;
                    top: 50%;
                    right: 20px;
                    transform: translateY(-50%);
                } */

                ul ul a {
                    font - size: 0.9 em!important;
                    padding - left: 30 px!important;
                    background: #ffffff;
                }

                ul.CTAs {
                    padding: 20 px;
                }

                ul.CTAs a {
                    text - align: center;
                    font - size: 0.9 em!important;
                    display: block;
                    border - radius: 5 px;
                    margin - bottom: 5 px;
                }

                a.download {
                    background: #fff;
                    color: #a8afbd;
                }

                a.article,
                a.article: hover {
                        background: #ffffff!important;
                        color: #a8afbd!important;
                    }

                    .sidebar - header img {
                        padding - left: 25 px;
                        padding - top: 30 px;
                        width: 90 % ;
                        display: block;
                        margin: 0 auto;
                        text - align: center;
                    }

                    .wrapper #sidebar hr {
                        border - top: 2 px solid #c2d7ff;
                        width: 90 % ;
                        margin: 0 auto;
                        /* Menengahkan elemen HR */
                    }

                /* ---------------------------------------------------
                CONTENT STYLE
                ----------------------------------------------------- */

                #content {
                    width: 100 % ;
                    padding: 20 px;
                    min - height: 100 vh;
                    transition: all 0.3 s;
                    background - color: #ececec;
                }

                #content.container {
                    display: flex;
                    justify - content: space - between;
                    align - items: center;
                    flex - wrap: wrap;
                }

                #content.container h2 {
                    color: #37398b;
        font-weight: bold;
        padding-top: 1em;
        font-size: 18px;
    }

    # content.isi {
                        color: black;
                        background - color: #ffffff;
                        border - radius: 15 px;
                        padding - bottom: 20 px;
                        padding - top: 20 px;
                        padding - left: 20 px;
                        padding - right: 30 px;
                        width: 100 % ;
                    }

                    /* #content .isi  */

                    #content.isi form {
                        padding - top: 25 px;
                        padding - left: 20 px;
                    }
                    #content.isi.group {
                        color: #a8afbd;
                        display: flex;
                        margin - bottom: 15 px;
                        padding - top: 5 px;
                    }

                    #content.isi.group a #addBlockchainBtn {
                        flex: 1;
                        border: 1 solid #000000;
        width: 2%;
        height: 2%;
        color: # 007 bff;
                        text - align: center;
                    }

                    /* #content .isi .group input {
                        /* width: 100%;
                        max-width: 200px; */
                    /* width: 30%; */
                    /* } */
                    /* #content .isi .group select {
                        /* width: 100%;
                        max-width: 200px; */
                    /* width: 30%; */
                    /* } */

                    /* .btn_1 {
                        margin-left: 10px;
                        background-color: red;
                        color: white;
                        padding: 8px 16px;
                        text-decoration: none;
                        display: inline-block;
                        border-radius: 4px;
                    }

                    .remove-blockchain-field {
                        background-color: red;
                        color: white;
                        padding: 5px 10px;
                        text-decoration: none;
                        display: inline-block;
                        border-radius: 4px;
                    }
                    #content .isi .label {
                        width: 150px;
                        color: #000000;
                        font-weight: bold;
                    }

                    #content .isi .separator {
                        margin: 0 5px;
                        color: #000000;
                        font-weight: bold;
                    }

                    #content .isi .value {
                        flex: 1;
                        padding-left: 20px;
                    }
                    #content .isi .value1 {
                        flex: 1;
                        padding-left: 20px;
                    } */
                    /* #content .isi .value img {
                        border: 1px solid #c9c1c1;
                        border-radius: 10px;
                        text-align: center;
                        margin-right: 15px;
                        vertical-align: middle;
                        margin-top: 20px;
                        width: 30%;
                        height: 40%;
                    } */

                    .btn_1 {
                        margin - left: 10 px;
                        background - color: rgb(47, 255, 0);
                        color: rgb(0, 0, 0);
                        padding: 4 px 5 px;
                        text - decoration: none;
                        display: inline - block;
                        border - radius: 4 px;
                    }

                    .remove - blockchain - field {
                        background - color: red;
                        color: white;
                        padding: 4 px 8 px;
                        text - decoration: none;
                        display: inline - block;
                        border - radius: 4 px;
                    }

                    .label {
                        width: 150 px;
                        color: #000000;
        font-weight: bold;
        display: inline-block; /* tambahkan ini agar label tidak pecah */
    }

    .separator {
        margin: 0 5px;
        color: # 000000;
                        font - weight: bold;
                    }

                    .value input {
                        width: 300 px;
                    }
                    .value select {
                        width: 300 px;
                    }

                    .value1 {
                        flex: 1;
                        padding - left: 20 px;
                        display: inline - block; /* tambahkan ini agar input field bersebelahan */
                    }

                    #content.isi.value1 img {
                        border: 1 px solid #c9c1c1;
                        border - radius: 10 px;
                        text - align: center;
                        margin - right: 15 px;
                        vertical - align: middle;
                    }

                    #content.isi form.button {
                        float: right;
                        padding: 3 px;
                        border - radius: 10 px;
                        width: 100 px;
                        background: #ffffff;
                        margin - right: 50 px;
                        border: 1 px solid #fafafa;
                        background - color: #00a8ed;
        color: white;
        font-weight: bold;
        font-size: 18px;
    }

    # content.isi.judul {
                            margin - bottom: 12 px;
                        }

                        #content.isi.judul.nama {
                            color: #37398b;
        font-weight: bold;
        float: left;
    }

    # content.isi.judul.keterangan_2 {
                                    color: #000000;
        text-align: left;
        padding-left: 28%;
        font-weight: bold;
    }
    # content.isi.judul.keterangan_2 select {
                                            color: #000000;
        font-weight: bold;
        border: none;
        margin: 0 auto;
    }
    # content.isi.judul.keterangan_2 select option {
                                                    color: #000000;
        font-weight: bold;
        border: none;
    }

    # content.isi.judul.keterangan img {
                                                            width: 10 % ;
                                                            height: 5 % ;
                                                            clip: rect(0, 50 % , auto, 0);
                                                        }

                                                        .isi.judul.keterangan input[type = "file"]::file - selector -
                                                        button {
                                                            border: none;
                                                            padding: 0.2 em 0.4 em;
                                                            border - radius: 10 px;
                                                            background - color: #37398b;
        transition: 1s;
        color: # ffffff;
                                                            width: 65 % ;
                                                        }

                                                    #content.isi.judul_1.nama_1 {
                                                        float: left;
                                                        color: #37398b;
        font-weight: bold;
        
    }

    # content.isi.judul_1.keterangan_1 {
                                                            float: right;
                                                            color: #a8afbd;
                                                            font - weight: bold;
                                                            padding - left: 15 % ;
                                                            padding - right: 5 % ;
                                                        }

                                                        #content.isi.keterangan {
                                                            color: #a8afbd;
                                                            text - align: left;
                                                            padding - left: 28 % ;
                                                        }
                                                        #content.isi.keterangan_3 {
                                                            color: #a8afbd;
                                                            text - align: left;
                                                            padding - left: 28 % ;
                                                        }
                                                        /* #content .isi .keterangan_1{
                                                            color: #A8AFBD;
                                                            text-align: left;
                                                            padding-left: 20%;
                                                        } */

                                                        #content.isi.hr_edt {
                                                            border - top: 2 px solid #c2d7ff;
                                                            width: 100 % ;
                                                            margin: 0 auto;
                                                            margin - top: 25 px;
                                                            margin - bottom: 15 px;
                                                        }

                                                        #content.container.add {
                                                            background - color: white;
                                                            border - radius: 10 px;
                                                            border: 1 px solid white;
                                                            background - color: white;
                                                            color: black;
                                                            margin - right: 25 px;
                                                            padding - left: 7 px;
                                                            padding - right: 7 px;
                                                            padding - top: 5 px;
                                                            padding - bottom: 5 px;
                                                            font - size: 14;
                                                            font - weight: bold;
                                                        }

                                                        #content.container a.btn btn - primary {
                                                            float: right;
                                                            border - radius: 10 px;
                                                            border: 1 px solid white;
                                                            background - color: white;
                                                            color: black;
                                                            margin - right: 25 px;
                                                            padding - left: 7 px;
                                                            padding - right: 7 px;
                                                            padding - top: 5 px;
                                                            padding - bottom: 5 px;
                                                            font - size: 14;
                                                            font - weight: bold;
                                                        }

                                                        /* Example CSS to move the search box to the left */
                                                        #content.isi.dataTables_wrapper.top.dataTables_filter {
                                                            float: left;
                                                            text - align: left;
                                                            margin - right: 100 px;
                                                        }

                                                        #content.isi.dataTables_wrapper.top.dataTables_filter input {
                                                            border - radius: 50 px;
                                                            width: 100 % ;
                                                            padding - right: 25 px;
                                                            padding - left: 20 px;
                                                        }

                                                        /* Example CSS to move the show entries dropdown to the right */
                                                        #content.isi.dataTables_wrapper.top.dataTables_length {
                                                            float: right;
                                                        }

                                                        .dataTables_filter label {
                                                            position: relative;
                                                        }

                                                        .dataTables_filter.search - icon {
                                                            position: absolute;
                                                            top: 50 % ;
                                                            left: 8 px; /* Adjust the right position as needed */
                                                            transform: translateY(-50 % );
                                                            color: #6c757d; /* Adjust the icon color */
    }

    # myTable thead th {
                                                                font - size: 14 px;
                                                                text - align: center;
                                                                color: #a8afbd;
                                                            }

                                                            #myTable_length label,
                                                            #myTable_info {
                                                                font - size: 14 px;
                                                            }

                                                            #myTable_paginate.paginate_button {
                                                                font - size: 14 px;
                                                            }

                                                            /* Custom styling for bank name and icon */
                                                            #myTable tbody img {
                                                                float: left;
                                                                border - radius: 10 px;
                                                                border: 1 px solid #a8afbd;
                                                                padding: 2 px;
                                                                background - color: white;
                                                                width: 10 % ;
                                                                height: 5 % ;
                                                                margin - left: 35 % ;
                                                                margin - right: 5 % ;
                                                                margin - top: 2 % ;
                                                            }

                                                            /* #myTable tbody p {
                                                                float: left;
                                                                color: #000000;
                                                                margin-top: 2%;
                                                            } */

                                                            #myTable tbody td {
                                                                text - align: center;
                                                                color: #000000;
        font-size: 12px;
    }
    # myTable tbody tr td p.stats {
                                                                    float: center;
                                                                }

                                                                #myTable tbody td.status - pending p,
                                                                    #myTable tbody td.status - failed p,
                                                                    #myTable tbody td.status - un - payment p,
                                                                    #myTable tbody td.status - success p {
                                                                        padding: 3 px;
                                                                        border - radius: 15 px;
                                                                        margin - top: 15 px;
                                                                        font - weight: bold;
                                                                    }

                                                                #myTable tbody td.status - pending p {
                                                                        background - color: #e9f0ff; /* Blue */
                                                                        color: #00a8ed; /* White text */
    }

    # myTable tbody td.status - failed p {
                                                                            background - color: #ffe8e8; /* Red */
                                                                            color: #ff0000; /* White text */
                                                                        }

                                                                        #myTable tbody td.status - un - payment p {
                                                                            background - color: #fff4cd; /* Orange */
                                                                            color: #ff7714; /* White text */
                                                                        }

                                                                        #myTable tbody td.status - success p {
                                                                                background - color: #cdffde; /* Green */
                                                                                color: #009633; /* White text */
    }

    # paymentModal.modal - dialog {
                                                                                    float: right;
                                                                                    padding - right: 8 ch;
                                                                                    max - width: 85 % ;
                                                                                    width: 80 % ;
                                                                                    border - radius: 50 px;
                                                                                }
                                                                                #paymentModal.modal - content {
                                                                                    width: 100 % ;
                                                                                }
                                                                                /* #content .modal-body {
                                                                                    width: 100%;
                                                                                    height: 100%;
                                                                                } */

                                                                                #content.modal - content.close {
                                                                                    text - align: right;
                                                                                    margin - right: 2 % ;
                                                                                    margin - top: 1 % ;
                                                                                    font - size: 30 px;
                                                                                }
                                                                                #content.modal - body {
                                                                                    /* padding-top: 2%; */
                                                                                    padding - left: 2 % ;
                                                                                }
                                                                                #content.modal - body.judul {
                                                                                    padding - bottom: 2 % ;
                                                                                }

                                                                                #content.modal - body.judul_3 {
                                                                                    padding - bottom: 4 % ;
                                                                                }

                                                                                #content.modal - body.judul_2 {
                                                                                    padding - bottom: 2 % ;
                                                                                }

                                                                                #content.modal - body.judul_1.nama_1 {
                                                                                        float: left;
                                                                                        color: #37398b;
        font-weight: bold;
        /* padding-right: 20%; */
    }
    /* # content.modal - body.judul_1.nama_2 {
                                                                                                float: right;
                                                                                                color: #37398b;
        font-weight: bold;
        padding-right: 17.3%;
    } */

    # content.modal - body.judul_1.keterangan_1 {
                                                                                                    float: left;
                                                                                                    color: #a8afbd;
                                                                                                    font - weight: bold;
                                                                                                    /* padding-right: 6.5%; */
                                                                                                }

                                                                                                #content.modal - body
                                                                                                .judul_1.keterangan_3 img {
                                                                                                    float: right;
                                                                                                    padding - right: 6.5 % ;
                                                                                                    width: 20 % ;
                                                                                                    height: 40 % ;
                                                                                                }
                                                                                                /* #content .modal-body .judul_1 .keterangan_2 {
                                                                                                    float: right;
                                                                                                    color: #a8afbd;
                                                                                                    font-weight: bold;
                                                                                                    padding-right: 10%;
                                                                                                    text-align: left;
                                                                                                } */

                                                                                                #content.modal - body
                                                                                                .judul_3.nama,
                                                                                                #content.modal - body.judul
                                                                                                .nama {
                                                                                                    color: #37398b;
        font-weight: bold;
        float: left;
        padding-left: 3%;
    }

    /* # content.modal - body.judul.nama_4 {
                                                                                                            color: #37398b;
        float: left;
        font-weight: bold;
        padding-left: 3%;
    } */
    # content.modal - body.judul_01 {
                                                                                                                display: flex;
                                                                                                            }

                                                                                                            #content.modal -
                                                                                                            body.judul_2
                                                                                                            .nama_2 {
                                                                                                                color: #37398b;
        font-weight: bold;
        float: left;
        padding-left: 3%;
    }

    /* # content.modal - body.judul_2.keterangan_2 {
                                                                                                                    color: #a8afbd;
                                                                                                                    text -
                                                                                                                    align: left;
                                                                                                                    padding -
                                                                                                                    left: 20 %
                                                                                                                    ;
                                                                                                                }*/

                                                                                                                /* #content .modal-body .judul .nama_3 {
                                                                                                                    color: #37398b;
                                                                                                                    font-weight: bold;
                                                                                                                    float: left;
                                                                                                                    padding-left: 3%;
                                                                                                                    padding-top: 1%;
                                                                                                                } */

                                                                                                                /* #content .modal-body .judul .nama_1 {
                                                                                                                    color: #37398b;
                                                                                                                    font-weight: bold;
                                                                                                                    float: left;
                                                                                                                    padding-left: 3%;
                                                                                                                } */

                                                                                                                #content
                                                                                                                .modal -
                                                                                                                body.judul_2
                                                                                                                .keterangan,
                                                                                                                #content
                                                                                                                .modal -
                                                                                                                body.judul_3
                                                                                                                .keterangan,
                                                                                                                #content
                                                                                                                .modal -
                                                                                                                body.judul
                                                                                                                .keterangan {
                                                                                                                    color: #a8afbd;
                                                                                                                    text -
                                                                                                                    align: left;
                                                                                                                    padding -
                                                                                                                    left: 28 %
                                                                                                                    ;
                                                                                                                }

                                                                                                                /* #content .modal-body .judul .keterangan_3 {
                                                                                                                    color: #a8afbd;
                                                                                                                    text-align: left;
                                                                                                                    padding-left: 28%;
                                                                                                                } */

                                                                                                                #content
                                                                                                                .modal -
                                                                                                                body
                                                                                                                .hr_edti {
                                                                                                                    border -
                                                                                                                        top:
                                                                                                                        2 px solid #c2d7ff;
                                                                                                                    width:
                                                                                                                        85 %
                                                                                                                        ;
                                                                                                                    margin:
                                                                                                                        0 auto;
                                                                                                                    margin -
                                                                                                                        bottom:
                                                                                                                        2 %
                                                                                                                        ;
                                                                                                                    padding
                                                                                                                        -
                                                                                                                        right:
                                                                                                                        10 %
                                                                                                                        ;
                                                                                                                    /* padding-top: 20%; */
                                                                                                                    /* margin-top: 1%; */
                                                                                                                }

                                                                                                                .blue -
                                                                                                                icon {
                                                                                                                    color: #ff0000; /* or any other blue styling */
                                                                                                                }

                                                                                                                .red -
                                                                                                                icon {
                                                                                                                    color: #00a8ed; /* or any other red styling */
    }

    /* # myTable tbody td div {
                                                                                                                        display: flex;
                                                                                                                        align -
                                                                                                                        items: center;
                                                                                                                        justify -
                                                                                                                        content: center;
                                                                                                                        text -
                                                                                                                        align: center;
                                                                                                                    }*/

                                                                                                                    /* ---------------------------------------------------
                                                                                                                    MEDIAQUERIES
                                                                                                                    ----------------------------------------------------- */

                                                                                                                    /* @media (max-width: 768px) {
                                                                                                                        #sidebar {
                                                                                                                            margin-left: -250px;
                                                                                                                        }

                                                                                                                        #sidebar.active {
                                                                                                                            margin-left: 0;
                                                                                                                        }

                                                                                                                        #sidebarCollapse span {
                                                                                                                            display: none;
                                                                                                                        }
                                                                                                                    } */

                                                                                                                    @media(
                                                                                                                        min -
                                                                                                                        width:
                                                                                                                        768 px
                                                                                                                        ) {
                                                                                                                        #sidebarCollapse {
                                                                                                                            display: none;
                                                                                                                        }
                                                                                                                    }

                                                                                                                    @media(
                                                                                                                        max -
                                                                                                                        width:
                                                                                                                        768 px
                                                                                                                        ) {
                                                                                                                        #sidebar {
                                                                                                                            margin
                                                                                                                                -
                                                                                                                                left:
                                                                                                                                -
                                                                                                                                250 px;
                                                                                                                        }

                                                                                                                        #sidebar
                                                                                                                            .active {
                                                                                                                                margin
                                                                                                                                    -
                                                                                                                                    left:
                                                                                                                                    0;
                                                                                                                            }

                                                                                                                        #content
                                                                                                                            .isi form
                                                                                                                            .button {
                                                                                                                                width: 100 %
                                                                                                                                ; /* Atau nilai lain yang sesuai */
                                                                                                                                margin -
                                                                                                                                right: 0;
                                                                                                                            }

                                                                                                                        #content
                                                                                                                            .isi
                                                                                                                            .group input {
                                                                                                                                width: 100 %
                                                                                                                                ;
                                                                                                                                max -
                                                                                                                                width: 200 px;
                                                                                                                            }
                                                                                                                        #content
                                                                                                                            .isi
                                                                                                                            .group select {
                                                                                                                                width: 100 %
                                                                                                                                ;
                                                                                                                                max -
                                                                                                                                width: 200 px;
                                                                                                                            }

                                                                                                                        /* #sidebarCollapse {
                                                                                                                            display: block;
                                                                                                                            position: fixed;
                                                                                                                            left: 10px;
                                                                                                                            top: 10px;
                                                                                                                            z-index: 1000;
                                                                                                                        } */
                                                                                                                    }
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
    </script> --}}

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
                <li class="{{ Request::is('/logout') ? 'active' : '' }}">
                    <a href="{{ route('logout') }}">
                        <iconify-icon icon="tabler:logout"></iconify-icon> Log Out
                    </a>
                </li>

            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            @yield('content')
        </div>
</body>

</html>
