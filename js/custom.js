document.addEventListener('DOMContentLoaded', (event) => {


    const username = "1d1851feeb1c0568654c4b6fbdd8195253718d552ca71f1af8ab3940e16a4fb6";
    const password = "f718950afdb18fb31a425072b4dfa8240fb8df570436facf40a942e17fc6bac5";

    //const username= 'KLcGUfRtvVFQFEMUXcE';
    //const password= '_Wx46NC9J_BT-4yUmMA';
    
    var conf = {
        endpoint: 'https://cloud.scorm.com/lrs/VHZKZQF1QN/sandbox/statement/',
        user: username,
        password: password,
        headers: {
            'Content-Type': 'application/json',
            'X-Experience-API-Version': '1.0.3',
            'Accept': 'application/json',
            'Cache-Control': 'no-cache',
            'Authorization': 'Basic ' + btoa(username + ':' + password)
        }
    };
    ADL.XAPIWrapper.changeConfig(conf);

        // No es necesario usar event.preventDefault() aquí
        if (typeof ADL === 'undefined') {
            console.error("xAPI Wrapper no cargada");
            return;
        }
        console.log("xAPI Wrapper se ha cargado");
        console.log(typeof ADL);

        console.log("------------------------------------------------------------------------------------------------------")

    function sendStatement(activity, result) {
        const statement = {
            "actor": {
                "name": "Ariel",
                "mbox": "mailto:jugador1@example.com"
            },
            "verb": {
                "id": "http://adlnet.gov/expapi/verbs/answered",
                "display": { "en-US": "answered" }
            },
            "object": {
                "id": "http://example.com/juego/actividad1",
                "definition": { "name": { "en-US": activity } }
            },
            "result": { "success": !!result } // Asegurar booleano
        };

        ADL.XAPIWrapper.sendStatement(statement, function(err, resp) {
            if (err) {
                console.error("Error al enviar el statement:", err);
            } else {
                console.log("Statement enviado con éxito:", statement);
            }
        });
    }

    sendStatement("Pregunta 1", true);

   
});

/*
    const username = "1d1851feeb1c0568654c4b6fbdd8195253718d552ca71f1af8ab3940e16a4fb6";
    const password = "f718950afdb18fb31a425072b4dfa8240fb8df570436facf40a942e17fc6bac5";
    
    var conf = {
        endpoint: 'http://152.74.151.37:8080/xapi/',
        user: username,
        password: password,
        headers: {
            'Content-Type': 'application/json',
            'X-Experience-API-Version': '1.0.3',
            'auth': 'Basic ' + toBase64(username + ':' + password)
        }
    };
    ADL.XAPIWrapper.changeConfig(conf);

*/
    /*
    function sendStatement(activity, result) {
        const statement = {
            "actor": {
                "name": "Ariel",
                "mbox": "mailto:jugador1@example.com"
            },
            "verb": {
                "id": "http://adlnet.gov/expapi/verbs/answered",
                "display": { "en-US": "answered" }
            },
            "object": {
                "id": "http://example.com/juego/actividad1",
                "definition": { "name": { "en-US": activity } }
            },
            "result": { "success": !!result } // Asegurar booleano
        };

        ADL.XAPIWrapper.sendStatement(statement, function(err, resp) {
            if (err) {
                console.error("Error al enviar el statement:", err);
            } else {
                console.log("Statement enviado con éxito:", statement);
            }
        });
    }

    sendStatement("Pregunta 1", true);
    */
