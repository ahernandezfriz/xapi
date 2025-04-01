document.addEventListener("DOMContentLoaded", () => {
    // Selecciona todos los elementos arrastrables y las zonas de destino
    const items = document.querySelectorAll(".drag-item");
    const dropZones = document.querySelectorAll(".drop-zone");

    console.log("Items:", items);
    console.log("Drop Zones:", dropZones);

    // Agrega evento de inicio de arrastre a cada elemento
    items.forEach(item => {
        item.addEventListener("dragstart", (event) => {
            event.dataTransfer.setData("text", event.target.dataset.type); // Guarda el tipo de elemento
            event.dataTransfer.setData("id", event.target.innerText); // Guarda el texto del elemento
        });
    });

    // Agrega eventos a las zonas de destino
    dropZones.forEach(zone => {
        // Permite soltar elementos en la zona
        zone.addEventListener("dragover", (event) => {
            event.preventDefault();
        });

        // Maneja el evento de soltar el elemento
        zone.addEventListener("drop", (event) => {
            event.preventDefault();
            const type = event.dataTransfer.getData("text"); // Obtiene el tipo del elemento
            const id = event.dataTransfer.getData("id"); // Obtiene el nombre del elemento
            
            // Buscar el elemento correcto basado en su data-type y texto
            const draggedItem = Array.from(document.querySelectorAll(`.drag-item[data-type="${type}"]`))
            .find(item => item.innerText.trim() === id.trim());

            if (draggedItem) {
                event.target.appendChild(draggedItem);
            } else {
                console.error("Elemento no encontrado:", type, id);
            }
        });
    });
});

// Función para verificar si los elementos fueron colocados correctamente
function verificarRespuestas() {
    const correctAnswers = {
        "hardware": ["Mouse", "Teclado", "Monitor"],
        "software": ["Word", "Excel", "Chrome"]
    };

    let results = [];
    let allCorrect = true;

    // Recorre cada zona de destino para verificar las respuestas
    document.querySelectorAll(".drop-zone").forEach(zone => {
        let zoneId = zone.id;
        let itemsInZone = Array.from(zone.children).map(item => item.innerText);

        itemsInZone.forEach(item => {
            let isCorrect = correctAnswers[zoneId].includes(item);
            results.push({
                item: item,
                category: zoneId,
                correct: isCorrect
            });
            
            // Busca el elemento con un atributo data-id en lugar de innerText
            let draggedItem = document.querySelector(`.drag-item[data-id="${item}"]`);

            if (draggedItem) {
                draggedItem.classList.add(isCorrect ? "correct" : "incorrect");
            } else {
                console.error(`No se encontró el elemento: ${item}`);
            }

            if (!isCorrect) allCorrect = false;
        });
    });

    // Muestra un mensaje de retroalimentación
    document.getElementById("feedback").innerText = allCorrect ? "¡Todo correcto!" : "Algunas respuestas son incorrectas.";
    
    // Envía los resultados a xAPI
    enviarA_xAPI(results);
}

// Función para enviar los resultados a un LRS usando xAPI
function enviarA_xAPI(results) {
    const statement = {
        "actor": {
            "mbox": "mailto:usuario@example.com", // Correo del usuario (puede ser dinámico)
            "name": "Usuario",
            "objectType": "Agent"
        },
        "verb": {
            "id": "http://adlnet.gov/expapi/verbs/completed", // Acción realizada
            "display": { "en-US": "completed" }
        },
        "object": {
            "id": "http://example.com/drag-and-drop", // Identificador único del ejercicio
            "definition": {
                "name": { "en-US": "Drag and Drop Exercise" },
                "description": { "en-US": "User categorized items as Software or Hardware." }
            }
        },
        "result": {
            "success": results.every(r => r.correct), // Indica si todas las respuestas fueron correctas
            "response": JSON.stringify(results) // Guarda los resultados en formato JSON
        }
    };
    
    // Envía la declaración a xAPI usando xAPIWrapper
    ADL.XAPIWrapper.sendStatement(statement);
}
