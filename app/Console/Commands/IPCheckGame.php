<?php

namespace App\Console\Commands;

use App\SourceQuery\SourceQuery;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;

class IPCheckGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ip {ip_port}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check ip game';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->get_info();
    }

    public function get_info()
    {
        try{
            $query = new SourceQuery();
            $ip_port = explode(':', $this->argument('ip_port'));
            $query->Connect($ip_port[0], $ip_port[1], 1, SourceQuery::SOURCE);

            $table = new Table($this->output);
            $table->setHeaders([
                '<fg=black>Name</>', '<fg=black>Value</>'
            ]);

            $info_server = $query->GetInfo();
            foreach ($info_server as $key=>$value){
                $data[] = [ucwords($key), $value];
            }

            $table->setRows($data);
            $table->render();
        }catch (\Exception $e){
            $this->info($e->getMessage());
        }
    }
}
