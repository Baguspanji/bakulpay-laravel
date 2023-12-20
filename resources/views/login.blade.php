<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakulpay | Login</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(to right, #37398B, #00A8ED);
            height: 100vh;
        }

        form {
            display: inline-grid;
        }

        .card-login {
            box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
            -webkit-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
            -moz-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
            width: 35%;
            background: white;
            padding: 1em;
            border-radius: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            height: 70%;
        }

        .card-header {
            text-align: center;
            font-size: 25px;
            color: #0099ff;
        }

        .card-header img {
            height: 40%;
            width: 70%;
            margin-left: 45px;
        }


        form.form-login {
            width: 100%;
        }

        input.form-input {
            text-align: center;
            padding: 1em;
            width: 90%;
            border-radius: 50px;
            border: 1px solid #00A8ED;
            margin: 0 auto;
        }

        label.form-label {
            color: #37398B;
            padding: 0.5em;
            margin-top: 0.5em;
            margin-left: 35px;
            font-weight: bold;
        }

        button.btn.btn-login {
            width: 90%;
            background-color: #0099ff;
            border: none;
            padding: 1em;
            border-radius: 50px;
            color: white;
            font-size: 18px;
            text-align: center;
            margin: 20px auto;
            font-weight: bold;
        }

        @media(max-width: 360px) {
            .card-login {
                box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -webkit-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -moz-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                width: 80%;
                background: white;
                padding: 1em;
                border-radius: 10px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                height: 90%;
            }
        }

        @media(max-width: 411px) {
            .card-login {
                box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -webkit-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -moz-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                width: 80%;
                background: white;
                padding: 1em;
                border-radius: 10px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                height: 90%;
            }
        }

        @media(max-width: 414px) {
            .card-login {
                box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -webkit-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -moz-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                width: 80%;
                background: white;
                padding: 1em;
                border-radius: 10px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                /* height: 55%; */
                height: 90%;
            }
        }

        @media(max-width: 768px) {
            .card-login {
                box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -webkit-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -moz-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                width: 80%;
                background: white;
                padding: 1em;
                border-radius: 10px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                height: 90%;
            }
        }

        @media(max-width: 1024px) {
            .card-login {
                box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -webkit-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                -moz-box-shadow: -3px -7px 31px 13px rgba(0, 0, 0, 0.07);
                width: 80%;
                background: white;
                padding: 1em;
                border-radius: 10px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                height: 70%;
            }
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="card-login">
            <div class="card-main">
                <div class="card-header">
                    <img src="{{ asset('assets/images/logo bakulpay.png') }}" alt="Logo">
                </div>
                <div class="card-body">
                    {{-- <form class="form-login" method="POST" action="{{ route('login') }}">
                    @csrf
                        <label class="form-label">Username</label>
                        <input type="email" name="email" class="form-input">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input">
                        <button type="submit" class="btn btn-login">Login</button>
                    </form> --}}
                    <form class="form-login" method="POST" action="{{ route('ProsesLogin') }}">
                        @csrf
                        <label class="form-label">Username</label>
                        <input type="email" name="email" class="form-input">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input">
                        <button type="submit" class="btn btn-login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
