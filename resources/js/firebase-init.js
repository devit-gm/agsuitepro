import { initializeApp } from 'firebase/app';
import { getMessaging, getToken, onMessage } from 'firebase/messaging';

const firebaseConfig = {
    apiKey: "AIzaSyAKDn17J0jzjYrQFCGF7WRN6Lt4AW4n7PA",
    authDomain: "go-mezzix.firebaseapp.com",
    projectId: "go-mezzix",
    storageBucket: "go-mezzix.firebasestorage.app",
    messagingSenderId: "234995051320",
    appId: "1:234995051320:web:f32c705f863362b936afcd",
    measurementId: "G-2VHQ757K08"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

export { messaging, getToken, onMessage };
