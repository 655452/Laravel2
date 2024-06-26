// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
        apiKey: "AIzaSyBwYztX1dfl96nKgVe0es2IIaG2V8MNTYQ",
        authDomain: "food-bank-daba5.firebaseapp.com",
        projectId: "food-bank-daba5",
        storageBucket: "food-bank-daba5.appspot.com",
        messagingSenderId: "296922475241",
        appId: "1:296922475241:web:de031cbc623514c07f9e78",
        measurementId: "G-N0T426TC1Q"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
