# php-lnd
A PHP class for interacting with the Bitcoin Lightning Network Daemon (LND) REST API using cURL.

This class provides a basic example for communicating with the Lightning Network Daemon from within PHP.
Requests are sent synchronously using cURL. SSL/TLS is optional.
The class has no dependencies and should run on all recent versions of PHP.

When instantiating a new instance of the class, you should provide a path to a macaroon file.
Macaroons are like cookies, and are used by LND to authenticate all incoming API requests.
As such, you should ensure this file is stored securely. outside of any publicly accessible directory. 

For more information on macaroon usage within LND, see https://github.com/lightningnetwork/lnd/blob/master/docs/macaroons.md 

![PHP-lnd-example](http://rosstitute.co.uk/lnd/php-lnd-light.png)

## installation
Include the class in your PHP project:

`require_once("classes/lnd.class.php");`

## usage
Instantiate a new LND object then set both the macaroon path and LND host information.

`$lnd = new lnd();`

`$lnd->setHost('86.122.84.24:8080');`

`$lnd->loadMacaroon('../admin.macaroon');`

You're now ready to begin making API requests. 
See this repositories `example..php` files for basic examples of working with LND.  
See the full LND V1 API documentation at https://api.lightning.community/rest 
