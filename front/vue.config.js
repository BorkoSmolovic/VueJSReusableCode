// let ip = '192.168.10.104';
// let ip = '192.168.10.105';
 let ip = 'localhost';
//let port = 8001;
let port = 8000;
// let port = 80;
/* NEMOJ DA MIJENJAS STVARI,  SAMO ZAKOMENTARISI AKO NE KORISTIS !!! */
module.exports = {
    devServer: {
        proxy: {
            '^/api': {
                target: 'http://' + ip + ':' + port,
            },
        },
        disableHostCheck: true
    }
};
