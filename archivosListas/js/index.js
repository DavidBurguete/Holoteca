var reconnectTimeout = 2000;
var host = "192.168.1.20"; //SERVIDOR MQTT (jarvis)
var port = 9001;
var SI = "ON", NO = "OFF";
let arrayInterruptores = ["I1", "I2", "I3", "I4"];
let comandoTopico = ["cmnd/Interruptor2A/POWER1", "cmnd/Interruptor2A/POWER2", "cmnd/Interruptor1A/POWER1", "cmnd/Interruptor1A/POWER2"];
let estadoTopico = ["stat/Interruptor2A/POWER1", "stat/Interruptor2A/POWER2", "stat/Interruptor1A/POWER1", "stat/Interruptor1A/POWER2"];

window.addEventListener("load", function (e) {


    for (let valorInterruptor = 1; valorInterruptor <= arrayInterruptores.length; valorInterruptor++) {
        let interruptor = document.getElementById("Int" + valorInterruptor);
        if(interruptor !== null){
            interruptor.addEventListener("click", function () {
                Deslizador(interruptor, arrayInterruptores[valorInterruptor - 1]);
            });
        }
    }

    function Deslizador(boton, interruptor) {
        boton.checked ? send_message(interruptor, SI) : send_message(interruptor, NO);
    }

    function send_message(CANAL, OPCION) {

        if (CANAL == arrayInterruptores[0])
            var topic = comandoTopico[0];
        if (CANAL == arrayInterruptores[1])
            var topic = comandoTopico[1];
        if (CANAL == arrayInterruptores[2])
            var topic = comandoTopico[2];
        if (CANAL == arrayInterruptores[3])
            var topic = comandoTopico[3];

        var msg = OPCION;
        console.log(msg);

        message = new Paho.MQTT.Message(msg);
        message.destinationName = topic;
        mqtt.send(message);
        return false;
    }
});

function MQTTconnect() {
    console.log("connecting to " + host + " " + port);
    mqtt = new Paho.MQTT.Client(host, port, "clientjsaaa");
    var options = {
        timeout: 3,
        onSuccess: onConnect,
    };
    mqtt.onMessageArrived = onMessageArrived;
    mqtt.connect(options);
    return false;
}
function onConnect() {
    console.log("on Connect ");
    // Ahora me suscribo a los "topicos"...
    sub_topics();
    // Como ya estoy conectado, activo el estado del sistema a OK
    document.getElementById('status').style.backgroundColor = "#AAFFBB";
    document.getElementById('status').innerHTML = "OK";
    // "Pregunta" el estado actual de los interruptores.
    message = new Paho.MQTT.Message(" ");
    for (let i = 0; i < comandoTopico.length; i++) {
        message.destinationName = comandoTopico[i];
        mqtt.send(message);
    }
}

function onMessageArrived(r_message) {
    out_msg = r_message.payloadString;
    console.log(out_msg);

    for (let i = 0; i < estadoTopico.length; i++) {
        if (r_message.destinationName == estadoTopico[i])
            var SELECC = (i + 1);
    }

    var checkbox = document.getElementById("Int" + SELECC);
    out_msg == "ON" ? document.getElementById("Desliz" + SELECC).style.backgroundColor = "#DD5533" : document.getElementById("Desliz" + SELECC).style.backgroundColor = "#ccc";
    if (checkbox.checked == true & out_msg == "OFF")
        document.getElementById("Int" + SELECC).checked = false;
    if (checkbox.checked == false & out_msg == "ON")
        document.getElementById("Int" + SELECC).checked = true;
}
function sub_topics() {
    for (let i = 0; i < estadoTopico.length; i++) {
        console.log("Subscribing to topic =" + estadoTopico[i]);
        mqtt.subscribe(estadoTopico[i]);
    }
}

//Javascript menú lateral
let abierto;

window.addEventListener("load", function(e){
    document.getElementById("abrir").addEventListener("click", abrirCerrar);
    document.getElementById("cerrar").addEventListener("click", closeNav);
    abierto = false;
});


function abrirCerrar(){
    abierto?closeNav():openNav();
    abierto?abierto=false:abierto=true;
}

function openNav() {
    document.getElementsByClassName("sidenav")[0].style.width = "300px";
}

function closeNav() {
    document.getElementsByClassName("sidenav")[0].style.width = "0";
}