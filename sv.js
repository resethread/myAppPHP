var siofu = require('socketio-file-upload');
var app = express().use(siofu.router).listen(8080);