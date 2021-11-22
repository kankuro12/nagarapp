@if(Auth::user()->level==3)
    <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js"></script>
    <script>
        // Initialize Firebase
        // TODO: Replace with your project's customized code snippet
        var config = {
            apiKey: "AIzaSyASF43dCoNCNboaDY4jhCTnolAtBUVBWuM",
            projectId: "bestsecurityservices-77fbe",
            messagingSenderId: "55218616136",
            appId: "1:55218616136:web:c78c9daaa984f6174c257d"
        };
        firebase.initializeApp(config);

        const messaging = firebase.messaging();
        messaging
            .requestPermission()
            .then(function () {
                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function(token) {
                axios.get('{{route('firebase.subscribe')}}')
                then((res)=>{});
                TokenElem.innerHTML = "token is : " + token
            })
            .catch(function (err) {
                console.log("Unable to get permission to notify.", err);
            });

    </script>
    @endif