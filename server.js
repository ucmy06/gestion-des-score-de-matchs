const io = require('socket.io')(3000, {
    cors: {
        origin: "*",
    }
});

io.on('connection', (socket) => {
    console.log('New connection: ' + socket.id);

    // Vous pouvez écouter des événements ici
    socket.on('message', (data) => {
        console.log('Message received:', data);
        // Vous pouvez renvoyer des données aux clients
        socket.broadcast.emit('message', data);
    });

    socket.on('disconnect', () => {
        console.log('Disconnected: ' + socket.id);
    });
});
