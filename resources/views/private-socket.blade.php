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
        'authEndpoint' : ' broadcasting/auth',
        'token' : 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMDUxMDJiZjE4M2RhNTM4ODJmMTViNTJkZjU5OTMwMDMxMGYzOGJjODE3Mzg0YTExMmI5MDZmMzkxYjgwNDBmY2YzNDczOTk4ZmEyODE5ZjMiLCJpYXQiOjE1ODE5MjQ1NTIsIm5iZiI6MTU4MTkyNDU1MiwiZXhwIjoxNjEzNTQ2OTUyLCJzdWIiOiIxNyIsInNjb3BlcyI6W119.sSA2Jm0TifLTnXSQUKUpy4GmszH7xJvw5FFMGo580ziUDdDulOIgO3ocpli4AGRKWmIEgEeJpe3iEp5qbTYFsK83FuIkhjZJKpwgYrWF2VEc6np654C9gLUb50x-sp5qJsvb5WyyLL03jdzbtF4oSUKzwhj5cXkeb9aKwQOhPpEVYvqvrHkgUS5gORtHz48PUZVRPmUJeJENgWPY3JOkQfLpy95Mbk8cw9kmReLAH1Jw_B4ueEt05ZNVOBMtU1mpl2rvK2VQVSM41cGRumvkfWu_PZD9xu4o_99a0GiRMg6J0amSIU7lOG9HQlWuUlUcv7ONLuMR9kQBo3z3Vobf0iTO4ZUXoMqGYBd1CQQZWOrzL7XcwvyOUCCT2fER-8nKarn5IV4jr3ePGBm7Msb1vEe7hdukUNwIG7rS64AMZ02ql7YTWy6whSMm0yPM6GM_RyHoIlgaRstjCOrcSkyCRPY73sjji5BZMuMTKdLPHDPzsaRI5MlLnBkggsvuUR0sqWEM7aIWa7gkl1-yxUgIyNcb_qZzA84o46fKn7c6bIp_cJ1H5DS2c33EM742f0vE7OOITXsbxkNwI3B0HLk6vvl5NbRpPVL02G1M8STypOoiVpFGysYdntDQxJZlFg-ofytJG1_fLuFCT2OV-2mP5pSB-YuXjRLLCwNaa65fO_g',
    };

    var pusher = new Pusher(this.app.key, {
        wsHost: app.host,
        wsPort: app.wsPort,
        disableStats: true,
        authEndpoint: app.authEndpoint,
        auth: {
            headers: {
                'Authorization' : 'Bearer ' + app.token,
            }
        },
        enabledTransports: ['ws', 'flash']
    });
    pusher.connection.bind('connected', () => {
        console.log('connected');
        pusher.subscribe('private-user.17')
            .bind('App\\Events\\UserPush', (data) => {
                console.log(data);
            });
    });
</script>

</body>
</html>
