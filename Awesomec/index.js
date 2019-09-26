import { AppRegistry } from 'react-native';
import App from './App';
import PushNotification  from 'react-native-push-notification';
PushNotification.configure({
    // (required) Called when a remote or local notification is opened or received
    onNotification: function(notification) {
        console.log( 'NOTIFICATION:', notification );
    },
    senderId : "209641468953",
});
AppRegistry.registerComponent('Awesomec', () => App);
