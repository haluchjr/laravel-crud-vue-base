// resources/js/logger.js

export function sendErrorToLaravel(errorData) {
    fetch('/api/log-javascript-error', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(errorData)
    }).catch(err => {
        console.error('Falha ao enviar log para o servidor:', err);
    });
}

export function initGlobalLogger() {
    // 1. Captura erros globais comuns (SyntaxError, ReferenceError, etc.)
    window.onerror = function (message, url, line, column, error) {
        sendErrorToLaravel({
            message: message,
            url: url,
            line: line,
            column: column,
            stack: error ? error.stack : 'N/A'
        });
        return false; 
    };

    // 2. Captura Promises rejeitadas fora do Vue
    window.addEventListener('unhandledrejection', function (event) {
        let message = event.reason;
        let stack = 'N/A';

        if (event.reason instanceof Error) {
            message = event.reason.message;
            stack = event.reason.stack;
        }

        sendErrorToLaravel({
            message: 'Unhandled Promise Rejection: ' + message,
            url: window.location.href,
            line: 0,
            column: 0,
            stack: stack
        });
    });
}