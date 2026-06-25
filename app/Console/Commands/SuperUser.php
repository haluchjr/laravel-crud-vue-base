<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SuperUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:super-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando a configuração de privilégios de banco de dados...');

        $database = config('database.connections.mysql.database');
        $user     = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $rootPassword = env('MYSQL_ROOT_PASSWORD');
        if (empty($rootPassword)) {
                $this->error('Ação abortada: A variável MYSQL_ROOT_PASSWORD não foi encontrada no ambiente.');
                return Command::FAILURE;
        }

        try {
        // 2. O PULO DO GATO: Altera as credenciais da conexão do Laravel em tempo de execução para ROOT
        config(['database.connections.mysql.username' => 'root']);
        config(['database.connections.mysql.password' => $rootPassword]);
        
        // Purga a conexão antiga para o Laravel forçar o login com o novo usuário (root)
        DB::purge('mysql');

        // 3. Agora o comando roda com permissões administrativas máximas
        DB::statement("CREATE USER IF NOT EXISTS '{$user}'@'172.%.%.%' IDENTIFIED BY '{$password}';");
        DB::statement("GRANT ALL PRIVILEGES ON `{$database}`.* TO '{$user}'@'172.%.%.%';");
        DB::statement("DROP USER IF EXISTS '{$user}'@'%';");
        DB::statement("FLUSH PRIVILEGES;");

        $this->info('Usuário de produção configurado com sucesso usando privilégios de ROOT!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Erro ao configurar privilégios: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
