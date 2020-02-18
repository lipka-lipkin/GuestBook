<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>WebSockets Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
</head>

<body>

<script>
    var app = {
        'key' : 'key',
        'host' : '127.0.0.1',
        'wsPort' : '6001',
    };

    var pusher = new Pusher(this.app.key, {
        wsHost: app.host,
        wsPort: app.wsPort,
        disableStats: true,
        authEndpoint: app.authEndpoint,
        enabledTransports: ['ws', 'flash']
    });
    pusher.connection.bind('connected', () => {
        console.log('connected');
        pusher.subscribe('public')
            .bind('App\\Events\\PublicPush', (data) => {
                console.log(data);
            });
    });
</script>

</body>
</html>
