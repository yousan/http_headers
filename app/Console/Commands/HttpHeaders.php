<?php

namespace App\Console\Commands;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
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
	    $fetch_headers = array_merge(['URL', 'HTTP Status Code'],
		    explode(',', $fetch_headers_str));
	    var_dump($fetch_headers);
	    $this->info("Hello $name");
	    $this->info("Headers ${fetch_headers_str}");
	    $response = $this->doRequest('GET');
	    $val = [];
	    foreach ( $fetch_headers as $header_name ) {
	    	if ( $response instanceof Response ) {
			    $val[ $header_name ] = implode(', ', $response->getHeader( $header_name ));
		    }
	    }
	    $val['URL'] = 'http://www.l2tp.org';
	    $val['HTTP Status Code'] = $response->getStatusCode();
	    var_dump($fetch_headers, $val);
	    $this->table($fetch_headers,
	    	$val);
	    return true;
    }

    private function doRequest($method) {
	    $base_url = 'http://www.l2tp.org';
	    $client = new Client( [
		    'base_uri' => $base_url,
	    ] );

	    $path = '/index.html';
	    try {
		    $response = $client->request( $method, $path,
			    [
				    'allow_redirects' => false,
			    ] );
	    } catch (ClientException $e) {
	    	$response = $e->getResponse();
	    	// do nothing
	    }
	    return $response;
    }
}
