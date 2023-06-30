<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="/build/assets/app-c6eddbdb.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #13254c;
        }

        ::-webkit-scrollbar-thumb {
            background: #061128;
        }

        #botmanWidgetRoot div:nth-child(0) {
    position: fixed !important;
    top: 50% !important; /* Change the desired vertical position */
    right: 10px !important; /* Change the desired horizontal position */
}

#botmanWidgetRoot div:nth-child(4) {
    display: none !important;
}

    </style>
</head>

<body style="background: #05113b;">


    @php
    $hideAppOnRoutes = ['login', 'register'];
    $currentRoute = Route::currentRouteName();
    $hideApp = in_array($currentRoute, $hideAppOnRoutes);
    @endphp

    @unless($hideApp)

    <!-- Load the React app -->
    <div id="react-app"></div>

    <!-- Load the React app -->
    <script src="{{ asset('/react/index-e710406c.js') }}"></script>
    @endunless

    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    <script>
        var botmanWidget = {
            aboutText: 'Botman Weather',
            introMessage: "Hello! Please type 'Weather in' followed by any city."
        };
    </script>


    <div>
        @if(Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                        in</a>

                    @if(Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery('#button-submit').on('click', function () {
                var $value = jQuery('#input').val();

                $('#content-box').append('<div class="mb-2">' +
                    '<div class="float-right px-3 py-2" ' +
                    'style="width: 270px; float: right; margin-top: 100px; background: #4acfee; border-radius: 10px; font-size: 85%">' +
                    '<h1>' + $value + '</h1>' +
                    '</div>' +
                    '<div style="clear: both"></div>' +
                    '</div>');

                $.ajax({
                    type: 'post',
                    url: '{{ url('send') }}',
                    data: {
                        'input': $value
                    },
                    success: function (data) {
                        $('#content-box').append('<div class="d-flex mb-2">' +
                            '<div class="mr-2" style="width: 45px; margin-top: 100px; height: 45px">' +
                            '<img src="https://icon-library.com/images/avatar-icon-images/avatar-icon-images-4.jpg" ' +
                            'width="100%" height="100%" style="border-radius: 50px;">' +
                            '</div>' +
                            '<div class="text-white px-3 py-2" ' +
                            'style="width: 500px; background: #13254b; border-radius:10px; margin-top: 100px; font-size: 85%">' +
                            '<h1>' + data + '</h1>' +
                            '</div>' +
                            '</div>');
                        $value = $('#input').val('');
                    }
                });
            });
        });

    </script>
</body>

</html>
