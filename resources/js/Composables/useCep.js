// useCep.js
import { ref } from 'vue';
import axios from 'axios';

export function useCep() {
    const erro = ref(null);

    const buscarCepNoViaCep = async (numeroCep) => {
        // Remove traços, espaços ou letras
        const cepLimpo = numeroCep.toString().replace(/\D/g, '');
        
        // Validação básica de tamanho antes de gastar requisição
        if (cepLimpo.length !== 8) {
            erro.value = 'CEP inválido. Deve conter 8 dígitos.';
            return null;
        }

        erro.value = null;

        try {
            const response = await axios.get(`https://viacep.com.br/ws/${cepLimpo}/json/`);
            
            // O ViaCep responde com status 200 mesmo se o CEP não existir, 
            // mas manda um objeto contendo "erro: true". Tratamos isso aqui:
            if (response.data && response.data.erro) {
                erro.value = 'CEP não encontrado.';
                return null;
            }

            // Retorna os dados já mapeados e padronizados para o seu projeto
            return {
                cep: cepLimpo,
                endereco: response.data.logradouro || '',
                bairro: response.data.bairro || '',
                cidade: response.data.localidade || '',
                estado: response.data.uf || ''
            };

        } catch (err) {
            console.error("Erro na requisição do CEP:", err);
            erro.value = 'Erro ao conectar ao serviço de CEP.';
            return null;
        }
    };

    // Devolvemos as variáveis de estado e a função para quem for importar
    return {
        buscarCepNoViaCep,
        erro
    };
}