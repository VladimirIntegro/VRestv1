# VRestv1
Light REST API on PHP. Can be used as an example and starting point for a concrete project.
To start using the API create your data storage, add your config file in /src/AppBundle/Config/CoreConfig.php.
The example source of the config file (don't forget to insert your actual credentials):
namespace AppBundle\Config;

/**
 * Application base configuration.
 * 
 * @author Vladimir Zhitkov
 */
class CoreConfig {
    
    const DB = [
        'host' => '127.0.0.1',
        'user' => 'username',
        'pass' => 'userpassword',
        'dbname' => 'thedbname',
    ];
    
    const AUTH_PARAMS = [
        "allowedips" => [
            "127.0.0.1",
        ],
        "username" => "AuthUserName",
        // Password hash generated by PHP's password_hash(). Compares by password_verify().
        "userpassw" => 'GeneratedUserPasswordHash',
    ];
    
}

Author Vladimir Zhitkov
MIT license. All rights reserved.
