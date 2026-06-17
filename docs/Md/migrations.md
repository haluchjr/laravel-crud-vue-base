### LARAVEL MIGRATIONS - GUIA DE REFERÊNCIA COMPLETO (CHEAT SHEET)

#### TIPOS DE COLUNAS (MÉTODOS E CORRESPONDÊNCIA SQL)

| Método Laravel                      | Tipo SQL (Geral)   | Descrição e Casos de Uso |
| :--- | :--- | :--- |
| `$table->id();`                     | BIGINT UNSIGNED     | Chave primária padrão (Auto-incremento).|
| `$table->string('nome', 150);`      | VARCHAR(150)        | Textos curtos (Nomes, emails, senhas). Máx: 255 se omitido.|
| `$table->text('corpo');`            | TEXT                | Textos longos (Artigos, posts de blog).|
| `$table->mediumText('descricao');`   | MEDIUMTEXT          | Textos muito longos (Conteúdo extenso).|
| `$table->longText('historico');`     | LONGTEXT            | Textos gigantescos (Logs, backups em texto).|
| `$table->char('sigla', 2);`         | CHAR(2)             | Texto de tamanho fixo (Estados UF, siglas de países).|
| &nbsp; | &nbsp; | &nbsp; |
| `$table->integer('total');`         | INT                 | Inteiro padrão (De -2,14 bilhões a 2,14 bilhões).|
| `$table->bigInteger('acessos');`    | BIGINT              | Inteiro gigante (Para contadores massivos).|
| `$table->mediumInteger('votos');`   | MEDIUMINT           | Inteiro médio (De -8,3 milhões a 8,3 milhões).|
| `$table->smallInteger('idade');`    | SMALLINT            | Inteiro pequeno (De -32.768 a 32.767).|
| `$table->tinyInteger('status');`    | TINYINT             | Inteiro minúsculo (De -128 a 127). Ideal p/ enums manuais.|
| `$table->unsignedInteger('qtd');`   | INT UNSIGNED        | Inteiro padrão apenas positivo (dobra a capacidade positiva).|
| &nbsp; | &nbsp; | &nbsp; |
| `$table->boolean('ativo');`         | TINYINT(1) / BOOL   | Booleano (0 = falso, 1 = verdadeiro).|
| `$table->decimal('preco', 8, 2);`   | DECIMAL(8,2)        | Valores monetários precisos (Total dígitos, decimais).|
| `$table->float('nota', 4, 2);`      | FLOAT(4,2)          | Ponto flutuante aproximado (Pesos, médias).|
| `$table->double('precisao', 15, 8);`| DOUBLE(15,8)        | Ponto flutuante de dupla precisão (Coordenadas GPS).|
| &nbsp; | &nbsp; | &nbsp; |
| `$table->date('aniversario');`      | DATE                | Apenas data (AAAA-MM-DD).|
| `$table->dateTime('evento');`       | DATETIME            | Data e Hora (AAAA-MM-DD HH:MM:SS).|
| `$table->time('alarme');`           | TIME                | Apenas Hora (HH:MM:SS).|
| `$table->timestamp('criado_em');`   | TIMESTAMP           | Carimbo de data/hora do sistema (Fuso horário/UTC).|
| `$table->timestamps();`             | TIMESTAMP (x2)      | Cria automaticamente 'created_at' e 'updated_at'.|
| `$table->softDeletes();`            | TIMESTAMP           | Cria 'deleted_at' para exclusão lógica (Soft Delete).|
| &nbsp; | &nbsp; | &nbsp; |
| `$table->binary('ficheiro');`   | BLOB                | Dados binários (Imagens, PDFs guardados no banco).|
| `$table->json('configuracoes');`    | JSON                | Dados estruturados em formato JSON nativo.|
| `$table->uuid('codigo_unico');`     | UUID                | Identificador Único Universal (ID não sequencial).|
| `$table->ipAddress('ip_usuario');`  | VARCHAR(45) / IP    | Endereço IP (Suporta IPv4 e IPv6).|
| `$table->macAddress('dispositivo');`| VARCHAR(17)         | Endereço MAC de placas de rede.|


#### MODIFICADORES DE COLUNA (CUSTOMIZAÇÃO E REGRAS)

| Método Encadeado                  | Efeito no Banco de Dados|
| :--- | :--- |
| `->nullable()`                      | Permite que o campo receba valores nulos (NULL). Campo opcional.|
| `->default($valor)`                 | Define um valor padrão se nenhum for enviado (ex: ->default(0)).|
| `->always()`                        | Obriga o banco a gerar valores sempre (usado com colunas identity).|
| `->charset('utf8mb4')`              | Define um conjunto de caracteres específico para a coluna.|
| `->collation('utf8mb4_unicode_ci')` | Define a colação/regras de comparação para a coluna.|
| `->comment('Texto aqui')`           | Adiciona um comentário interno na tabela sobre a coluna.|
| `->invisible()`                     | Torna a coluna invisível em consultas "SELECT *" (SQL Server/MySQL8).|
| `->storedAs($expressao)`            | Cria uma coluna gerada (Virtual) cujo valor é guardado em disco.|
| `->virtualAs($expressao)`           | Cria uma coluna gerada (Virtual) calculada em tempo de execução.|
| `->after('outra_coluna')`           | Posiciona a coluna fisicamente após outra (Apenas MySQL).|
| `->first()`                         | Coloca a coluna como a primeiríssima da tabela (Apenas MySQL).|


#### ÍNDICES E RESTRIÇÕES DE SEGURANÇA

|Método / Sintaxe                  | Tipo de Índice      | Objetivo|
| :--- |:--- | :--- |
| `$table->unique('email');`          | UNIQUE              | Impede dados duplicados na coluna (Emails, NIF/CPF).|
| `$table->index('apelido');`         | INDEX (Apenas)      | Acelera pesquisas com WHERE e ORDER BY nessa coluna.|
| `$table->fullText('biografia');`    | FULLTEXT            | Permite buscas textuais avançadas (MATCH AGAINST).|
| `$table->primary('id_composto');`   | PRIMARY KEY         | Define manualmente a chave primária (ou composta).|
* Nota: Pode passar um array para criar índices compostos (ex: `$table->index(['user_id', 'status']);`)



#### CHAVES ESTRANGEIRAS E RELACIONAMENTOS (FOREIGN KEYS)
| Abordagem Moderna (Laravel 8+)    | Equivalente Clássico (Laravel Antigo) |
| :--- | :--- |
| `$table->foreignId('user_id')`     | $table->unsignedBigInteger('user_id');|
| `->constrained()`             | $table->foreign('user_id')->references('id')->on('users');|
| `->onDelete('cascade');`      | ->onDelete('cascade');|

#### Tipos de Ação no onDelete() / onUpdate():
| Comando Laravel | Comportamento no Banco de Dados | Requisito / Efeito |
| :--- | :--- | :--- |
| `->onDelete('cascade')` | Se o Pai for apagado, apaga automaticamente todos os Filhos. | Remove em cascata. |
| `->onDelete('set null')` | Se o Pai for apagado, o ID no Filho fica `NULL`. | **Requer** `->nullable()` na coluna. |
| `->onDelete('restrict')` | Impede o Pai de ser apagado se houver Filhos ligados a ele. | Protege contra exclusão acidental. |
| `->onDelete('no action')` | Não faz nada, deixa o erro acontecer no nível do banco. | Comportamento padrão do SQL. |

#### Relacionados ao TIMESTAMP
| Comando | Descrição |
| :--- | :--- |
| `$table->timestamp('created_at')->useCurrent();` | Faz o próprio BANCO DE DADOS gerar <br>a data atual no INSERT |
| `$table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();` | Faz o BANCO DE DADOS gerar a data<br> no INSERT e atualizar sozinho no UPDATE|

#### EXEMPLO PRÁTICO: UMA TABELA REAL EM PRODUÇÃO
```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();                                    // BIGINT Auto-increment
    $table->foreignId('user_id')->constrained()      // FK ligada à tabela 'users'
          ->onDelete('cascade');                     
    $table->string('titulo', 150);                   // VARCHAR(150)
    $table->string('slug')->unique();                // VARCHAR(255) Único
    $table->text('conteudo');                        // TEXT
    $table->string('capa_url')->nullable();          // Opcional
    $table->boolean('publicado')->default(false);     // Padrão: Não publicado
    $table->integer('visualizacoes')->default(0);    // Contador
    $table->timestamps();                            // created_at e updated_at
    $table->softDeletes();                           // deleted_at (Lixeira)
});
```