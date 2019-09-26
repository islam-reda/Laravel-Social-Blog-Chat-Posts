
var io = require('socket.io')(6003),Redis = require('ioredis'),redis = new Redis();


redis.psubscribe('*',function (error,count) {
    //..

    console.log(error);
    console.log(count);

});


redis.on('pmessage',function (pattern,channel,message) {

    message = JSON.parse(message);

    io.emit(channel + ':' + message.event,message.data.message);
    io.emit(channel + ':' + message.event,message.data.comment);
    io.emit(channel + ':' + message.event,message.data.reply);
    io.emit(channel + ':' + message.event,message.data.notification);
    io.emit(channel + ':' + message.event,message.data.ticketcomment);
    console.log(channel,message.event);
});
