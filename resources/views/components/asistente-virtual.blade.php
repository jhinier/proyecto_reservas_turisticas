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
    project-id="asistente-virtual-499100"
    agent-id="862e2089-75d1-423c-a013-77d5403bc1e9"
    language-code="es"
    location="global"
    environment-id="draft"
    max-query-length="-1">
    <df-messenger-chat-bubble
        chat-title="Asistente Virtual La Candelaria">
    </df-messenger-chat-bubble>
</df-messenger>