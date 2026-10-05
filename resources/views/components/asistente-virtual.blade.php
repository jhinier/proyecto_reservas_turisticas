<link rel="stylesheet" href="https://www.gstatic.com/dialogflow-console/fast/df-messenger/prod/v1/themes/df-messenger-default.css">

<style>
    df-messenger {
        z-index: 99999;
        position: fixed;
        bottom: 20px;
        right: 20px;
        
        /* Variables para forzar el color verde y quitar el azul */
        --df-messenger-primary-color: #07b25f;
        --df-messenger-on-primary-color: #ffffff;
        --df-messenger-chat-background: #ffffff;
        --df-messenger-input-background: #ffffff;
        --df-messenger-message-user-background: #d1fae5;
        --df-messenger-message-bot-background: #f3f4f6;
        --df-messenger-font-family: ui-sans-serif, system-ui, sans-serif;
    }
</style>

<script src="https://www.gstatic.com/dialogflow-console/fast/df-messenger/prod/v1/df-messenger.js"></script>

<df-messenger
    project-id="asistentecandelaria"
    agent-id="15637663-a3df-4cea-8a31-7f57cce0dad1"
    language-code="es"
    max-query-length="-1">
    <df-messenger-chat-bubble
        chat-title="Asistente Virtual La Candelaria">
    </df-messenger-chat-bubble>
</df-messenger>

<script>
window.addEventListener('df-response-received', (event) => {
    // Evita que Dialogflow Messenger renderice la respuesta automáticamente
    event.preventDefault();

    const messenger = document.querySelector('df-messenger');
    const mensajes = event.detail.data.messages;

    mensajes.forEach(message => {
        // Deja pasar solo el texto normal; descarta tarjetas info/citas/fuentes
        if (message.type === 'text') {
            messenger.renderCustomText(message.text);
        }
        // Si quieres conservar otros tipos de rich content (chips, botones, etc.)
        // que SÍ quieras mostrar, agrega aquí sus 'else if' con renderCustomCard.
    });
});</script>