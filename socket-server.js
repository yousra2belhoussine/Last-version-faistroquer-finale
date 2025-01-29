const server = require('http').createServer();
const io = require('socket.io')(server, {
    cors: {
        origin: '*',
        methods: ['GET', 'POST']
    }
});

const PORT = process.env.SOCKET_PORT || 6001;

io.on('connection', (socket) => {
    console.log('Client connected:', socket.id);

    socket.on('join', (room) => {
        socket.join(room);
        console.log(`Client ${socket.id} joined room: ${room}`);
    });

    socket.on('leave', (room) => {
        socket.leave(room);
        console.log(`Client ${socket.id} left room: ${room}`);
    });

    socket.on('disconnect', () => {
        console.log('Client disconnected:', socket.id);
    });
});

server.listen(PORT, () => {
    console.log(`Socket.io server running on port ${PORT}`);
}); 