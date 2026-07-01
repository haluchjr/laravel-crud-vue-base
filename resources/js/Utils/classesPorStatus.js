export const obterClasseStatus = (statusId) => {
    switch (statusId) {
        case 1:
            return 'badge bg-warning text-dark'; // Amarelo para pendente
        case 3:
            return 'badge bg-success';          // Verde para pago/concluído
        case 2:
            return 'badge bg-danger';           // Vermelho para cancelado
        default:
            return 'badge bg-secondary';        // Cinza padrão
    }
};