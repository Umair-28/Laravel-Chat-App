<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat App</title>
</head>
<body>
    <div id="app">
        <ul>
            <li v-for="message in messages">@{{ message }}</li>
        </ul>
        <input v-model="newMessage" @keyup.enter="sendMessage">
        <button @click="sendMessage">Send</button>

        <!-- Include Vue.js -->
        <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

        <!-- Include Axios for HTTP requests -->
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- Include Socket.IO client library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.0/socket.io.js"></script>

        <!-- Initialize Vue app -->
        <script>
         
            new Vue({
                el: '#app',
                data: {
                    messages: @json($messages),
                    newMessage: ''
                },
                methods: {
                    sendMessage() {
                        console.log('Sending message:', this.newMessage);
        
                        axios.post('/send-message', { message: this.newMessage })
                            .then(response => {
                                console.log(response.data);
                                // After sending a message, fetch the latest messages
                                this.fetchMessages();
                            })
                            .catch(error => {
                                console.error(error);
                            });
        
                        this.newMessage = '';
                    },
                    fetchMessages() {
                        // Fetch latest messages from Redis
                        axios.get('/get-messages')
                            .then(response => {
                                this.messages = response.data.messages;
                            })
                            .catch(error => {
                                console.error('Error fetching messages:', error);
                            });
                    }
                },
                mounted() {
                    const socket = io('http://localhost:6001'); // Use your WebSocket server URL
        
                    // Log a message when a user is connected
                    socket.on('connect', () => {
                        console.log('User connected to WebSocket server');
                    });
        
                    // Listen for new chat messages on the public channel
                    socket.on('chat', message => {
                        console.log('Received message:', message);
        
                        // Update the messages in real-time
                        this.messages.push(message);
                    });
                }
            });
        </script>
        
    </div>
</body>
</html>
