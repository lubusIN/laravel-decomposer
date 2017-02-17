<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Decomposer</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            body {
                padding: 25px;
            }
            .ld-version-tag {
                background-color: #F5716C;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <th>Package Name : Version</th>
                    <th>Dependency Name : Version</th>
                </tr>
                @foreach($packages as $package)
                <tr>
                    <td>{{ $package['name'] }} : <span class="label ld-version-tag">{{ $package['version'] }}</span></td>
                    <td>
                    @foreach($package['dependencies'] as $dependencyName => $dependencyVersion)
                        {{ $dependencyName }}  :  <span class="label ld-version-tag">{{ $dependencyVersion }}</span> <br>
                    @endforeach
                    </td>           
                </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>
