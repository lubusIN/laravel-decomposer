<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Decomposer</title>

        <!-- Bootstrap & Datatables -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">

        <!-- Styles -->
        <style>
            body {
                padding: 25px;
            }
            .ld-version-tag {
                background-color: #F5716C;
            }
            .bs-callout {
                padding: 20px;
                margin:  0  0 20px 0;
                border: 1px solid #eee;
                border-left-width: 5px;
                border-radius: 3px;
            }
            .bs-callout-primary {
                border-left-color: #428bca;
            }
            .bs-callout-primary h4 {
                color: #428bca;
            }
            .glyphicon-ok {
                color: #7ad03a;
            }
            .glyphicon-remove {
                color: red;
            }
            .panel-title {
                font-weight: 600;
            }
            .table th {
                color: #757575;
            }
            table.dataTable span.highlight {
              background-color: #FFF176;
              border-radius: 0.28571429rem;
            }
            #txt-report {
                margin: 10px 0;
            }
            #report-wrapper {
                display: none;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-12">
                <div class="bs-callout bs-callout-primary">
                  <p>Please share this information for troubleshooting:</p>
                  <button id="btn-report" class="btn btn-info btn-sm">Get System Report</button>
                  <a href="https://github.com/lubusIN/laravel-decomposer/blob/master/report.md" target="_blank" id="btn-about-report" class="btn btn-default btn-sm">Understand Report</a href="">

                  <div id="report-wrapper">
                    <textarea name="txt-report" id="txt-report" class="col-sm-12" rows="10" spellcheck="false" onfocus="this.select()">
                        ### Laravel Environment

                        - Laravel Version: {{ $laravelEnv['version'] }}
                        - Timezone: {{ $laravelEnv['timezone'] }}
                        - Debug Mode: {!! $laravelEnv['debug_mode'] ? '&#10004;' : '&#10008;' !!}
                        - Storage Dir Writable: {!! $laravelEnv['storage_dir_writable'] ? '&#10004;' : '&#10008;' !!}
                        - Cache Dir Writable: {!! $laravelEnv['cache_dir_writable'] ? '&#10004;' : '&#10008;' !!}
                        - Decomposer Version: {{ $laravelEnv['decomposer_version'] }}
                        - App Size: {{ $laravelEnv['app_size'] }}
                        @foreach($laravelExtras as $extraStatKey => $extraStatValue)
                        - {{ $extraStatKey }}: {{ is_bool($extraStatValue) ? ($extraStatValue ? '&#10004;' : '&#10008;') : $extraStatValue }}
                        @endforeach

                        ### Server Environment

                        - PHP Version: {{ $serverEnv['version'] }}
                        - Server Software: {{ $serverEnv['server_software'] }}
                        - Server OS: {{ $serverEnv['server_os'] }}
                        - Database: {{ $serverEnv['database_connection_name'] }}
                        - SSL Installed: {!! $serverEnv['ssl_installed'] ? '&#10004;' : '&#10008;' !!}
                        - Cache Driver: {{ $serverEnv['cache_driver'] }}
                        - Session Driver: {{ $serverEnv['session_driver'] }}
                        - Openssl Ext: {!! $serverEnv['openssl'] ? '&#10004;' : '&#10008;' !!}
                        - PDO Ext: {!! $serverEnv['pdo'] ? '&#10004;' : '&#10008;' !!}
                        - Mbstring Ext: {!! $serverEnv['mbstring'] ? '&#10004;' : '&#10008;' !!}
                        - Tokenizer Ext: {!! $serverEnv['tokenizer']  ? '&#10004;' : '&#10008;'!!}
                        - XML Ext: {!! $serverEnv['xml'] ? '&#10004;' : '&#10008;' !!}
                        @foreach($serverExtras as $extraStatKey => $extraStatValue)
                        - {{ $extraStatKey }}: {{ is_bool($extraStatValue) ? ($extraStatValue ? '&#10004;' : '&#10008;') : $extraStatValue }}
                        @endforeach

                        ### Installed Packages &amp; their version numbers

                        @foreach($packages as $package)
                        - {{ $package['name'] }} : {{ $package['version'] }}
                        @endforeach

                        @if(!empty($extraStats))
                        ### Extra Information

                        @foreach($extraStats as $extraStatKey => $extraStatValue)
                        - {{ $extraStatKey }} : {{ is_bool($extraStatValue) ? ($extraStatValue ? '&#10004;' : '&#10008;') : $extraStatValue }}
                        @endforeach
                        @endif
                    </textarea>
                    <button id="copy-report" class="btn btn-info btn-sm">Copy Report</button>
                  </div>
                </div>
            </div>
        </div>

        <div class="row"> <!-- Main Row -->

            <div class="col-sm-8"> <!-- Package & Dependency column -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Installed Packages and their Dependencies</h3>
                    </div>
                    <div class="panel-body">
                        <table id="decomposer" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Package Name : Version</th>
                                    <th>Dependency Name : Version</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($packages as $package)
                                <tr>
                                    <td>{{ $package['name'] }} : <span class="label ld-version-tag">{{ $package['version'] }}</span></td>
                                    <td>
                                        <ul>
                                            @if(is_array($package['dependencies']))
                                                @foreach($package['dependencies'] as $dependencyName => $dependencyVersion)
                                                    <li>{{ $dependencyName }} : <span class="label ld-version-tag">{{ $dependencyVersion }}</span></li>
                                                @endforeach
                                            @else
                                                <li><span class="label label-primary">{{ $package['dependencies'] }}</span></li>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- / Package & Dependency column -->

            <div class="col-sm-4"> <!-- Server Environment column -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Laravel Environment</h3>
                  </div>

                  <ul class="list-group">
                    <li class="list-group-item">Laravel Version: {{ $laravelEnv['version'] }}</li>
                    <li class="list-group-item">Timezone: {{ $laravelEnv['timezone'] }}</li>
                    <li class="list-group-item">Debug Mode: {!! $laravelEnv['debug_mode'] ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' !!}</li>
                    <li class="list-group-item">Storage Dir Writable: {!! $laravelEnv['storage_dir_writable'] ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' !!}</li>
                    <li class="list-group-item">Cache Dir Writable: {!! $laravelEnv['cache_dir_writable'] ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' !!}</li>
                    <li class="list-group-item">Decomposer Version: {{ $laravelEnv['decomposer_version'] }}</li>
                    <li class="list-group-item">App Size: {{ $laravelEnv['app_size'] }}</li>
                    @foreach($laravelExtras as $extraStatKey => $extraStatValue)
                    <li class="list-group-item">{{ $extraStatKey }}: {!! is_bool($extraStatValue) ? ($extraStatValue ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>') : $extraStatValue !!}</li>
                    @endforeach
                  </ul>
                </div>

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Server Environment</h3>
                  </div>

                  <ul class="list-group">
                    <li class="list-group-item">PHP Version: {{ $serverEnv['version'] }}</li>
                    <li class="list-group-item">Server Software: {{ $serverEnv['server_software'] }}</li>
                    <li class="list-group-item">Server OS: {{ $serverEnv['server_os'] }}</li>
                    <li class="list-group-item">Database: {{ $serverEnv['database_connection_name'] }}</li>
                    <li class="list-group-item">SSL Installed: {!! $serverEnv['ssl_installed'] ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' !!}</li>
                    <li class="list-group-item">Cache Driver: {{ $serverEnv['cache_driver'] }}</li>
                    <li class="list-group-item">Session Driver: {{ $serverEnv['session_driver'] }}</li>
                    <li class="list-group-item">Openssl Ext: {!! $serverEnv['openssl'] ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' !!}</li>
                    <li class="list-group-item">PDO Ext: {!! $serverEnv['pdo'] ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' !!}</li>
                    <li class="list-group-item">Mbstring Ext: {!! $serverEnv['mbstring'] ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' !!}</li>
                    <li class="list-group-item">Tokenizer Ext: {!! $serverEnv['tokenizer']  ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>'!!}</li>
                    <li class="list-group-item">XML Ext: {!! $serverEnv['xml'] ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' !!}</li>
                    @foreach($serverExtras as $extraStatKey => $extraStatValue)
                    <li class="list-group-item">{{ $extraStatKey }}: {!! is_bool($extraStatValue) ? ($extraStatValue ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>') : $extraStatValue !!}</li>
                    @endforeach
                  </ul>
                </div>

                @if(!empty($extraStats))
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">Extra Stats</h3>
                      </div>

                      <ul class="list-group">
                        @foreach($extraStats as $extraStatKey => $extraStatValue)
                            <li class="list-group-item">{{ $extraStatKey }}: {!! is_bool($extraStatValue) ? ($extraStatValue ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>') : $extraStatValue !!}</li>
                        @endforeach
                      </ul>
                    </div>
                @endif
            </div> <!-- / Server Environment column -->

        </div> <!-- / Main Row -->

        <!-- jQuery & Datables JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
        <script src="https://bartaz.github.io/sandbox.js/jquery.highlight.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.13/features/searchHighlight/dataTables.searchHighlight.min.js"></script>

        <!-- Initialize & config datatables -->
        <script>
            $(document).ready(function() {
                $('#decomposer').DataTable({
                    'order': [[ 0, 'desc' ]],
                    searchHighlight: true
                });

                s = document.getElementById("txt-report").value;
                s = s.replace(/(^\s*)|(\s*$)/gi,"");
                s = s.replace(/[ ]{2,}/gi," ");
                s = s.replace(/\n /,"\n");
                document.getElementById("txt-report").value = s;

                $('#btn-report').on('click', function() {
                    $("#report-wrapper").slideToggle();
                });

                $("#copy-report").on('click', function() {
                    $("#txt-report").select();
                    document.execCommand("copy");
                });
            });

        </script>

    </body>
</html>
