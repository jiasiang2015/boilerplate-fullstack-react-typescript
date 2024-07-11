<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-version="{{ $appVerison }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100..900&display=swap" rel="stylesheet">

        <title>{{ $appTitle }}</title>

        <script type="text/javascript">
            window.appUrl = '{{ $appUrl }}';
            window.appTimeZone = '{{ $appTimeZone }}';
            window.appVersion = '{{ $appVerison }}';

            window.assetUrl = function(path, withoutVersion) {
                var url = '{{ $assetUrl }}' + path;
                if (withoutVersion !== true) {
                    url += '?ver={{ $appVerison }}';
                }
                return url;
            }

            window.liffId = '{{ $liffId }}',
            window.liffLoginMockEnable = '{{ $liffLoginMockEnable }}',
            window.liffUrl = '{{ $liffUrl }}',

        </script>
        @if ($appDebugVconsole == true)
            <script src="https://unpkg.com/vconsole@latest/dist/vconsole.min.js"></script>
            <script>
                // VConsole will be exported to `window.VConsole` by default.
                var vConsole = new window.VConsole();
            </script>
        @endif


        @viteReactRefresh

        @vite(["resources/app/main.tsx", "resources/app/main.scss"])
    </head>

    <body>
        <div id="root"></div>
    </body>

</html>
