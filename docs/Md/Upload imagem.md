Atualizar o seu useForm
   ```javascript
    const formulario = useForm({
        id: null,
        cep: '',
        endereco: '',
        // ... seus outros campos ...
        foto: null, // 💡 Começa como null
    });```

Sempre que o usuário escolher um arquivo, precisamos jogar esse arquivo para dentro do formulario.foto.

// Controla situacao de imagem
// Se usuario vai upar foto preciso carregar no formulario.
const SelecionarFoto = (event) => {
    formulario.foto = event.target.files[0];
}
// Estados para controlar o modal de visualização da foto
const exibirModalFoto = ref(false);
const urlFotoModal = ref('');

// Função para disparar a abertura do modal
const verFoto = (foto) => {
    if (foto) {
        urlFotoModal.value = `/storage/${foto}`;
        exibirModalFoto.value = true;
    }
};
// Fim controle de situacao de imagem.


```html
<div class="mb-3">
    <label for="foto" class="form-label">Foto do Usuário</label>
    <input 
        type="file" 
        class="form-control" 
        id="foto" 
        @change="selecionarFoto" 
        accept="image/*"
    >
    <div v-if="formulario.errors.foto" class="text-danger small mt-1">
        {{ formulario.errors.foto }}
    </div>
</div>
```


AJustar no enviar
```javascript
const enviar = () => {
    const idFormulario = formulario.id;

    if (idFormulario) {
        // 💡 Em vez de formulario.put(), usamos formulario.post() enviando o _method: 'put'
        formulario.post(route('cadastro.update', { id: idFormulario }), {
            // Isso força o Inertia a injetar o spoofing de método correto para upload de arquivos
            forceFormData: true, 
            queryParams: { _method: 'put' } // Diz ao Laravel: "trate isso como PUT"
        });
    } else {
        // No cadastro comum (POST), o upload funciona direto sem truques
        formulario.post(route('cadastro.store'));
    }
};```


Criar o link simbólico do Storage (Terminal)

```bash
php artisan storage:link
```

No meu NovoUsuarioRequest.php 
RULES:

```php
    'foto' => [
        'nullable',        // Permite que o usuário não envie foto se não quiser
        'image',           // Garante que é um arquivo de imagem (jpeg, png, bmp, gif, svg, ou webp)
        'mimes:jpg,jpeg,png,webp', // Trava nos formatos de sua preferência
        'max:2048',        // Tamanho máximo do arquivo em Kilobytes (2048 KB = 2MB)
        
        // 💡 Validação de dimensões (pixels)
        'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
        
        // Alternativa se você quisesse uma imagem estritamente quadrada (ex: foto de perfil):
        // 'dimensions:ratio=1/1',
    ]```

MESSAGE:

```php
return [
        'foto.image' => 'O arquivo selecionado deve ser uma imagem.',
        'foto.mimes' => 'A imagem deve ser do tipo: JPG, JPEG, PNG ou WEBP.',
        'foto.max' => 'A imagem não pode ser maior que 2MB.',
        'foto.dimensions' => 'A imagem deve ter entre 100x100 e 2000x2000 pixels.',
    ];```

   public function store(NovoUsuarioRequest $request,)
    {
        // 1. Pega os dados validados
        $dados = $request->validated();

        // 2. Processa o arquivo e altera o valor de $dados['foto']
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $arquivo = $request->file('foto');
            
            // 1. Gera um nome único aleatório para não sobrescrever arquivos
            $nomeArquivo = md5(uniqid()) . '.' . $arquivo->getClientOriginalExtension();
            
            // 2. Move o arquivo DIRETO para public/usuarios/ dentro do seu projeto
            $arquivo->move(public_path('usuarios'), $nomeArquivo);
            
            // 3. Salva no banco o caminho relativo
            $dados['foto'] = 'usuarios/' . $nomeArquivo;
        }

        // 3. 🛑 O ERRO ESTAVA AQUI: Você deve passar $dados e NÃO $request->all()
        if ($this->cadastroRepository->salvar($dados)) { // 💡 Mude de $request->all() para $dados
            return redirect()->back()->with('success', 'Cadastrado com sucesso!');
        } else {
            if (isset($caminhoFoto)) {
                Storage::disk('public')->delete($caminhoFoto);
            }
            return redirect()->back()->with('error', 'Erro ao salvar.');
        }

    }

    public function update(NovoUsuarioRequest $request, $id)
    {
        // 1. Pega os dados validados pelo seu Form Request
        $dados = $request->validated();
        
        // 2. Busca o registro atual no banco pelo repositório para checar se ele já tinha foto
        $usuario = $this->cadastroRepository->buscarPorId($id); 

        // 3. Verifica se um NOVO arquivo de foto foi enviado
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $arquivo = $request->file('foto');
            
            // 💡 DELETAR A FOTO ANTIGA: Se o usuário já tinha uma foto salva, apaga ela direto da pasta pública
            if ($usuario->foto && file_exists(public_path($usuario->foto))) {
                unlink(public_path($usuario->foto)); // Deleta o arquivo físico antigo
            }

            // 💡 SALVAR A FOTO NOVA: Gera um nome único aleatório
            $nomeArquivo = md5(uniqid()) . '.' . $arquivo->getClientOriginalExtension();
            
            // Move o arquivo direto para public/usuarios/
            $arquivo->move(public_path('usuarios'), $nomeArquivo);
            
            // Define o caminho limpo que vai pro banco de dados (ex: 'usuarios/abc123...png')
            $dados['foto'] = 'usuarios/' . $nomeArquivo;

        } else {
            // 💡 TRUQUE DO INERTIA: Se não veio um arquivo novo, o Vue enviou a string do caminho antigo.
            // Para o Laravel não tentar atualizar a coluna com lixo ou dar erro, removemos o campo do array.
            // Assim, o banco mantém a foto que já estava lá intacta.
            unset($dados['foto']);
        }

        // 4. Envia os dados tratados para o repositório atualizar no MySQL
        if ($this->cadastroRepository->atualizar($id, $dados)) {
            return redirect()->back()->with('success', 'Cadastro atualizado com sucesso!');
        }
        
        return redirect()->back()->with('error', 'Erro ao atualizar cadastro.');
    }

Se quiser definir pasta espeficica:

Mude : USUARIOS para o qual desejar.
Ou sequiser algo dinamico.
$pastaDinamica = 'usuarios/' . date('Y/m'); // Resultado ex: usuarios/2026/06
$caminhoFoto = $request->file('foto')->store($pastaDinamica, 'public');


 php artisan make:migration add_foto --table=cadastro

...

    public function up(): void
    {
        Schema::table('cadastro', function (Blueprint $table) {
            $table->string('foto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cadastro', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};


php artisan migrate




Na view:
Tabela:
<td>
                        <button 
                            class="btn btn-sm btn-outline-primary me-1" 
                            :disabled="!item.foto"
                            @click="verFoto(item.foto)"
                            title="Visualizar Foto"
                        >
                            <i class="bi bi-eye"></i> 
                        </button>
                        <button class="btn btn-sm btn-outline-danger" @click="excluir(item.id)">Excluir</button>
                        <button class="btn btn-sm btn-outline-warning" @click="dadosForm(item)">Editar</button>
                    </td>

 <ModalBs 
            :show="exibirModalFoto" 
            title="Visualizar Foto do Usuário" 
            @close="exibirModalFoto = false"
        >
            <div class="text-center p-2">
                {{ urlFotoModal }}
                <img 
                    :src="urlFotoModal" 
                    class="img-fluid rounded border shadow-sm" 
                    style="max-height: 400px; object-fit: contain;" 
                    alt="Foto Ampliada"
                >
            </div>

            <template #actions>
                <button type="button" class="btn btn-secondary" @click="exibirModalFoto = false">
                    Fechar
                </button>
            </template>
        </ModalBs>

...

Se eu quiser mudar para outro lugar o local que vai salvar.
docker-compose

services:
    laravel.test:
        # ... outras configs ...
        volumes:
            - '.:/var/www/html' # Pasta do projeto atual
            - '/home/usuario/fotos_sistema:/var/www/html/public/usuarios' # 💡 O TRUQUE!

O que isso faz? Qualquer arquivo que o Laravel salvar em public/usuarios na verdade estará 
sendo gravado direto na pasta física /home/usuario/fotos_sistema da sua máquina real. 
Se você deletar o projeto inteiro, as fotos continuam seguras lá fora.

E na rede....
O que você vai precisar (Pré-requisitos no Windows)

Antes de ir para o código, garanta que na máquina Windows:

    A pasta destino esteja compartilhada na rede (ex: nome do compartilhamento: UploadsSistema).

    O usuário do Windows usado na conexão tenha permissão de Leitura e Escrita nessa pasta.

    Você saiba o IP dessa máquina Windows (ex: 192.168.1.50).

🛠️ Passo Único: Ajustar o seu docker-compose.yml

O Docker possui um driver nativo de volumes capaz de se conectar a redes CIFS/Samba. Nós vamos criar esse volume no final do arquivo e depois mapeá-lo no serviço do seu Laravel.

Abra o seu docker-compose.yml e faça duas alterações:

1. Declare o Volume de Rede no final do arquivo:

Vá até o final do seu docker-compose.yml, onde fica a propriedade global volumes:, e adicione o mapeamento do Windows:
volumes:
    sail-mysql:
        driver: local
    sail-redis:
        driver: local
    
    # 🛑 ADICIONE ESTE BLOCO AQUI:
    fotos_rede_windows:
        driver: local
        driver_opts:
            type: cifs
            # o=username,password define a credencial do Windows. vers=3.0 garante compatibilidade e performance
            o: "username=SEU_USUARIO_WINDOWS,password=SUA_SENHA_WINDOWS,vers=3.0,uid=1000,gid=1000"
            # Endereço IP do Windows e o nome da pasta compartilhada
            device: "//192.168.1.50/UploadsSistema"

2. Mapeie esse volume dentro do container do Laravel:

Agora suba o arquivo docker-compose.yml até encontrar o serviço do seu app (geralmente laravel.test). 
Na sessão de volumes dele, diga para o Docker jogar o volume de rede na pasta public/usuarios:    
services:
    laravel.test:
        # ... outras configurações do Sail ...
        volumes:
            - '.:/var/www/html'
            # 🛑 ADICIONE ESTA LINHA:
            - 'fotos_rede_windows:/var/www/html/public/usuarios'

Como aplicar as mudanças?

Como alteramos a estrutura do Docker, você precisa reiniciar os containers para que o Linux monte a rede Windows:
# 1. Derruba os containers atuais
./vendor/bin/sail down

# 2. Sobe novamente recriando os volumes
./vendor/bin/sail up -d