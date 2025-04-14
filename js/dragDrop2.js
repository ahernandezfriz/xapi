document.addEventListener("DOMContentLoaded", () => {
    const draggableItemsContainer = document.getElementById("draggable-items-container");
    const items = Array.from(draggableItemsContainer.children);

    // Función para mezclar elementos aleatoriamente
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    // Reorganiza los elementos arrastrables en orden aleatorio
    const shuffledItems = shuffleArray(items);
    shuffledItems.forEach(item => draggableItemsContainer.appendChild(item));

    const dragItems = document.querySelectorAll(".drag-item");
    const dropZones = document.querySelectorAll(".drop-zone");

    console.log("Items:", items);
    console.log("Drop Zones:", dropZones);

    // Agrega evento de inicio de arrastre a cada elemento
    dragItems.forEach(item => {
        item.addEventListener("dragstart", (event) => {
            event.target.classList.add("dragging"); // Agrega clase para estilo visual al arrastrar
            event.dataTransfer.setData("id", event.target.dataset.id); // Guarda el ID del elemento
        });

        item.addEventListener("dragend", (event) => {
            event.target.classList.remove("dragging"); // Quita el efecto al soltar
        });
    });

     // Agrega eventos a las zonas de destino
     dropZones.forEach(zone => {
        zone.addEventListener("dragover", (event) => {
            event.preventDefault();
            zone.classList.add("over"); // Resalta la zona al arrastrar un elemento encima
        });

        zone.addEventListener("dragleave", () => {
            zone.classList.remove("over"); // Quita el resaltado si el elemento se va
        });

        zone.addEventListener("drop", (event) => {
            event.preventDefault();
            zone.classList.remove("over"); // Quita el resaltado al soltar

            const id = event.dataTransfer.getData("id"); // Obtiene el ID del elemento arrastrado
            const draggedItem = document.querySelector(`.drag-item[data-id="${id}"]`);

            if (draggedItem && !zone.querySelector(".drag-item")) {
                // Asegura que solo se pueda colocar un elemento por zona
                zone.appendChild(draggedItem);
            }
        });
    });
});


// Función para verificar respuestas
function verificarRespuestas() {
    let results = [];
    let allCorrect = true;

    document.querySelectorAll(".drag-item").forEach(item => {
        const correctZone = item.dataset.correct; // Zona correcta para este elemento
        const parentZone = item.parentElement?.id || "none"; // Zona actual donde está el elemento (evita errores si no tiene padre)
        //const parentZone = item.parentElement.id;
        
        console.log("correctZone",correctZone);
        console.log("parentZone",parentZone)

        let isCorrect = (correctZone === parentZone); // Compara la zona correcta con la actual
        
        results.push({
            item: item.dataset.id, // Item que estoy arrastrando
            placedIn: parentZone,  // Zona donde lo solte 
            correct: isCorrect     // Es correcto o incorrecto
        });

        //console.log("Results: " , results)

        item.classList.remove("correct", "incorrect");
        item.classList.add(isCorrect ? "correct" : "incorrect");

        if (!isCorrect) allCorrect = false;
    });


    // Imprime los resultados en la consola para depuración
    console.log("Results Completo:", results);
    console.log("Results Correct ?:", results.every(r => r.correct));

    document.getElementById("feedback").innerText = allCorrect ? "¡Todo correcto!" : "Algunas respuestas son incorrectas.";

    enviarA_xAPI(results);
}




// Función para enviar resultados a xAPI
function enviarA_xAPI(results) {
    const username= 'KLcGUfRtvVFQFEMUXcE';
    const password= '_Wx46NC9J_BT-4yUmMA';

    const xapiConfig = {
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

    const statement = {
        "actor": {
            "mbox": "mailto:ariel@example.com",
            "name": "Usuario",
            "objectType": "Agent"
        },
        "verb": {
            "id": "http://adlnet.gov/expapi/verbs/completed",
            "display": { "en-US": "completed" }
        },
        "object": {
            "id": "http://example.com/drag-and-drop",
            "definition": {
                "name": { "en-US": "Drag and Drop Exercise" },
                "description": { "en-US": "User sorted images into the correct categories." }
            }
        },
        "result": {
            "success": results.every(r => r.correct),
            "response": JSON.stringify(results)
        }
    };

    ADL.XAPIWrapper.sendStatement(statement);
}
