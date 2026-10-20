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

    @media (max-width: 767px), (pointer: coarse) {
        df-messenger {
            touch-action: none;
            cursor: grab;
        }

        df-messenger.is-dragging {
            cursor: grabbing;
        }
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
});

(() => {
    const storageKey = 'asistenteVirtualPosition';
    const mobileQuery = window.matchMedia('(max-width: 767px), (pointer: coarse)');
    const edgePadding = 12;
    const dragThreshold = 8;
    let messenger = null;
    let startX = 0;
    let startY = 0;
    let startLeft = 0;
    let startTop = 0;
    let isPointerDown = false;
    let hasMoved = false;
    let suppressClickUntil = 0;

    const clamp = (value, min, max) => Math.min(Math.max(value, min), max);
    const isMobileDragEnabled = () => mobileQuery.matches;

    const getSavedPosition = () => {
        try {
            return JSON.parse(localStorage.getItem(storageKey) || 'null');
        } catch {
            return null;
        }
    };

    const savePosition = (left, top) => {
        try {
            localStorage.setItem(storageKey, JSON.stringify({ left, top }));
        } catch {
            // localStorage can be unavailable in private browsing modes.
        }
    };

    const applyPosition = (left, top) => {
        if (!messenger) {
            return null;
        }

        const rect = messenger.getBoundingClientRect();
        const maxLeft = window.innerWidth - rect.width - edgePadding;
        const maxTop = window.innerHeight - rect.height - edgePadding;
        const nextLeft = clamp(left, edgePadding, Math.max(edgePadding, maxLeft));
        const nextTop = clamp(top, edgePadding, Math.max(edgePadding, maxTop));

        messenger.style.left = `${nextLeft}px`;
        messenger.style.top = `${nextTop}px`;
        messenger.style.right = 'auto';
        messenger.style.bottom = 'auto';

        return { left: nextLeft, top: nextTop };
    };

    const restoreSavedPosition = () => {
        if (!messenger || !isMobileDragEnabled()) {
            return;
        }

        const savedPosition = getSavedPosition();

        if (savedPosition && Number.isFinite(savedPosition.left) && Number.isFinite(savedPosition.top)) {
            applyPosition(savedPosition.left, savedPosition.top);
        }
    };

    const resetInlinePosition = () => {
        if (!messenger) {
            return;
        }

        messenger.style.left = '';
        messenger.style.top = '';
        messenger.style.right = '';
        messenger.style.bottom = '';
    };

    const onPointerDown = (event) => {
        if (!isMobileDragEnabled() || event.button > 0) {
            return;
        }

        const rect = messenger.getBoundingClientRect();

        isPointerDown = true;
        hasMoved = false;
        startX = event.clientX;
        startY = event.clientY;
        startLeft = rect.left;
        startTop = rect.top;
        messenger.classList.add('is-dragging');
        messenger.setPointerCapture?.(event.pointerId);
    };

    const onPointerMove = (event) => {
        if (!isPointerDown || !isMobileDragEnabled()) {
            return;
        }

        const deltaX = event.clientX - startX;
        const deltaY = event.clientY - startY;

        if (!hasMoved && Math.hypot(deltaX, deltaY) < dragThreshold) {
            return;
        }

        hasMoved = true;
        event.preventDefault();
        applyPosition(startLeft + deltaX, startTop + deltaY);
    };

    const onPointerUp = (event) => {
        if (!isPointerDown) {
            return;
        }

        isPointerDown = false;
        messenger.classList.remove('is-dragging');
        messenger.releasePointerCapture?.(event.pointerId);

        if (!hasMoved) {
            return;
        }

        const rect = messenger.getBoundingClientRect();
        const position = applyPosition(rect.left, rect.top);

        if (position) {
            savePosition(position.left, position.top);
        }

        suppressClickUntil = Date.now() + 250;
        event.preventDefault();
    };

    const onClick = (event) => {
        if (Date.now() <= suppressClickUntil) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
    };

    const initDraggableAssistant = () => {
        messenger = document.querySelector('df-messenger');

        if (!messenger) {
            return;
        }

        restoreSavedPosition();

        messenger.addEventListener('pointerdown', onPointerDown);
        messenger.addEventListener('pointermove', onPointerMove);
        messenger.addEventListener('pointerup', onPointerUp);
        messenger.addEventListener('pointercancel', onPointerUp);
        messenger.addEventListener('click', onClick, true);

        window.addEventListener('resize', () => {
            if (isMobileDragEnabled()) {
                restoreSavedPosition();
            } else {
                resetInlinePosition();
            }
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDraggableAssistant, { once: true });
    } else {
        initDraggableAssistant();
    }
})();
</script>
