<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class HttpHeaders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'HttpHeaders:get '.
                           '{-f|--fetch-headers=: Comma separated headers you want to fetch [i.e. Server,Expires]} '.
                           '{name} '
    ;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets HTTP response headers with listed URLs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    $name = $this->argument("name");
	    $fetch_headers_str = $this->option('fetch-headers');
	    $fetch_headers = explode(',', $fetch_headers_str);
	    $this->info("Hello $name");
	    $this->info("Headers ${fetch_headers_str}");
	    return true;
    }

    private function doRequest() {
	    $base_url = 'http://example.com';
	    $client = new Client( [
		    'base_uri' => $base_url,
	    ] );

	    $path = '/index.html';
	    $response = $client->request( 'GET', $path,
		    [
			    'allow_redirects' => true,
		    ] );
	    $response_body = (string) $response->getStatusCode();
	    echo $response_body;
    }
}
