
// Inibe o F12 e exibe um aviso no console para usuários comuns, mas apenas em produção
export function initConsoleSecurity() {
    if (import.meta.env.MODE !== 'development' ) {
        const estiloTitulo = "color: red; font-size: 40px; font-weight: bold; -webkit-text-stroke: 1px black;";
        const estiloTexto = "color: #444; font-size: 16px; font-weight: 500; line-height: 1.5;";
        // 1. Limpa e exibe o aviso no console imediatamente

        console.clear();
        console.log("%cEspere! Não tem nada de interessante aqui.", estiloTitulo);
        // 2. Bloqueia o atalho F12 globalmente na janela do navegador
        window.addEventListener('keydown', (e) => {
            if (e.key === 'F12') {
                e.preventDefault();
                console.warn("Acesso ao console bloqueado por políticas de segurança.");
            }
        });
    }
}