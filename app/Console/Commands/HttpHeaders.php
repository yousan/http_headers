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
                           '{-f|--fetch-headers= : Comma separated headers you want to fetch [i.e. Server,Expires]} '.
                           '{-u|--urls= : Comma separated URLs you want to fetch} ' .
    '';

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
	    // $name = $this->argument("name");
	    $fetch_headers_str = $this->option('fetch-headers');
	    $this->info("Headers ${fetch_headers_str}");

	    $fetch_headers = array_merge(['URL', 'HTTP Status Code'],
		    explode(',', $fetch_headers_str));

	    $fetch_urls = explode(',', $this->option('urls'));

	    $val = [[]];
	    foreach ( $fetch_urls as $url ) {
		    $response = $this->doRequest($url, 'GET');
		    foreach ( $fetch_headers as $header_name ) {
			    if ( $response instanceof Response ) {
				    $val[ $url ][ $header_name ] = implode( ', ', $response->getHeader( $header_name ) );
			    }
		    }
		    $val[$url]['URL'] = $url;
		    $val[$url]['HTTP Status Code'] = $response->getStatusCode();
	    }
	    $this->table($fetch_headers,
	    	$val);
	    return true;
    }

    private function doRequest($url, $method) {
	    $client = new Client();

	    $path = '/index.html';
	    try {
		    $response = $client->request( $method, $url,
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
