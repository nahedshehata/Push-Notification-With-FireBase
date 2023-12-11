// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyDDs79VG_rXH7jf8E9F24n-VZe4elcu6co",
    authDomain: "push-913e8.firebaseapp.com",
    projectId: "push-913e8",
    storageBucket: "push-913e8.appspot.com",
    messagingSenderId: "72181620771",
    appId: "1:72181620771:web:513ac96216dc21d9e59196",
    measurementId: "G-67CQWPL6VW"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const options = {
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        options,
    );
});
