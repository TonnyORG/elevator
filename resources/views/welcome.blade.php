<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Elevator</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="http://getbootstrap.com/docs/4.0/examples/narrow-jumbotron/narrow-jumbotron.css" crossorigin="anonymous">
</head>
<body>
    <div class="container" id="app">
        <header class="header clearfix">
            <h3 class="text-muted">Elevator</h3>
        </header>

        <main role="main">
            <div class="jumbotron">
                <h1 class="display-3">Jumbotron heading</h1>
                <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                <p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p>
            </div>

            <div class="row marketing">
                <div class="col-2">
                    <building v-cloak></building>
                </div>

                <div class="col-10">
                    <elevators class="row"></elevators>
                        
                    <request v-cloak action="{{ action('API\ElevatorRequestController@store') }}"></request>

                    <hr />

                    <h4>Live Logs</h4>

                    <div class="card">
                        <div class="card-body">
                            This is some text within a card body.
                        </div>
                    </div>

                    <a href="#" class="btn pull-right btn-cs btn-outline-warning">Download Full Logs</a>
                </div>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; Antonio Valencia 2017</p>
        </footer>
    </div> <!-- /container -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/e13a770015.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var elevatorConfiguration = {!! json_encode(config('elevator')) !!};
    </script>
    <script src="/js/app.js" type="text/javascript"></script>
</body>
</html>
