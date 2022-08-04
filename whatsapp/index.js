var express = require('express');
var cors = require('cors')
var app = express();
var server = require('http').createServer(app);
var io = require('socket.io')(server);
server.listen(process.env.PORT || 4000);
console.log('Server is running ');
app.use(cors({
    origin: "http://localhost:4000"
}))
io.sockets.on( 'connection', function( client ) {
    console.log( "New client !" );
    io.sockets.emit('message', "konek");
});
