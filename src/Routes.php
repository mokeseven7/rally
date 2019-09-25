<?php

namespace Shop\Site;

//TODO :: What do you think is happening here? 
//--MM: Importing a class file that lives in a different directory, and therefore a different namespace. 
//--MM: If this site uses composer, i would expect a declaration of either psr-0 or psr-4 to be present in its composer.json file, and autload.php to be present in a file thats globally included. 
//--MM: If this site does not use composer, I would expect a manually created autoloader that utilizes spl_autoload or spl_autoload_register to be present somewhere in the codebase, again, likely in a globally included file.  
//--MM: At its core, PSR-0/4 is essentially a group of rules that defined a standard set of naming conventions for directory and file structure. If these rules are met in given codebase, a psr0/4 compliant autoloader can be utilized. Composer being the most popular. 
//--MM: This keeps our codebases from being riddled with require/include statements, gives us a concept of scope, and paved the way for modern DI containers. 
use Dsc\Mongo\Collection;

class Routes extends \Dsc\Routes\Group
{

    public function initialize()
    {
        //--MM: Best guess would be static method call or facade proxy to some kind of application object. 
        //--MM: If this site has a DI container, this method probably retrieves and instance of the entire application. 
        //--MM; ...Or, at minimum, anything thats been bound to the container. 
        //--MM: Some frameworks cannot provide you the container via DI. Which is kind of funny since its not a limitation of reflection.
        $f3 = \Base::instance();

        //TODO :: What do you think is happening here?  

        //--MM: First, I would expect the  \Dsc\Routes\Group base class to have a static method/facade proxy (via __call proxy), to implement an initialize() method that accepts some default meta parameters defined by the child class (this class).
        //--MM: Taking a step back quickly, I would expect \Dsc\Routes\Group to be a base class provided by this code bases URL router. 
        //--MM: Traditionally, the job of a router in an MVC style framework was simply to map HTTP requests to a class and method. 
        //--MM: Although the flexibility has grown substantially over the years, the core concept remains the same.  

        //--MM: 'namespace' => "Tell me where you live", eg. lets think about all urls as API's to a certain resource. Taking this assumption into consideration, we'll need a "thing" that actually accepts an HTTP request, and returns a response. please tell me where the "Address" controller lives.  
        //--MM 'url_prefix' => Usually used for semantic versioning of API's. Not the only use case, but the most common in my experience. Could also be used to make urls more human readable if you have a very long and unpredictable, or otherwise difficult to understand resource name. 
        //--MM: Finally, I would add that all routes defined in this file will have the above two rules applied.
        //--MM: eg. The Address controller exists at \Shop\Sites\Controllers\Address, and if a url_prefix was defined here, it would be prepended to all routes, even if there route declaration defines their own url prefix. 
        $this->setDefaults(array(
            'namespace' => '\Shop\Site\Controllers',
            'url_prefix' => ''
        ));
        //TODO :: What do you think is happening here? 
        //--MM: I would his codebase is using some kind of MVC paradigm. 
        //--MM: This is probably a definition of what should happen when the site receives a GET request at <vhostRoot>/.
        //--MM: Specifically, when a GET request comes into <vhostRoot>/ it should be handled by a Controller class that lives  at \Shop\Site\Controllers\Home. 
        //--MM: I would also expect this class to implement an index() method (noted by the action param), which will be given anything after / as params to that method. 
        $this->add('/', 'GET', array(
            'controller' => 'Home',
            'action' => 'index'
        ));

        //--MM: The @ symbol definetly has me confused. 
        //--MM: I think it might actually be a string literal of "/@trackingnumber"... 100% could be wrong there.
        $this->add('/part/packages/@trackingnumber', 'GET', array(
            'controller' => 'Product',
            'action' => 'Packages'
        ));

        /* LOTS OF ROUTES HAVE BEEN OMMITED */

        //TODO :: How do you think that this method differs from the above methods in this class?   
        //--MM: My first observation is that this method does not define a single controller and action.
        //--MM: Often times modern routing engines understand the concept of a CRUD resource, or more commonly known as a "resource" class. 
        //--MM: These classes generally allow for creating, reading, updating, and deleting of a specific resource, or related group of resources. 
        //--MM: The definition of "Resource" classes generally service one of two purposes. 
        //--MM: Allow for a CLI tool to assist with boilerplate/scaffolding. eg. If i know i want to have full CRUD functionality, a tool like artisan can scaffold out the bare bones methods.
        //--MM: Validation, If i know a certain controller class should expose full Crud functionality, i will treat it as a contract/interface of sorts, and ensure all required methods are implemented. 
        //--MM: I would think this definition serves one of those two purposes. 

        //--MM: I was in the audience when Adam Waltham gave this talk in 2017, and i belive its one of the best talks ever given on the subject in the context of PHP.
        //--MM: Weather you've been on the job for 10 years, or 10 minutes, I believe anyone can get a bit of value out of that talk. 
        //--MM: https://www.youtube.com/watch?v=MF0jFKvS4SI
        $this->addCrudItem('Address', array(
            'namespace' => '\Shop\Site\Controllers',
            'url_prefix' => '/account/addresses'
        ));

        //--MM; Accept a GET or POST to account/address route. 
        //--MM: Let the controller figure out how to deal with the rest. 
        $this->add('/account/addresses', 'GET|POST', array(
            'controller' => 'Address',
            'action' => 'index'
        ));


        //--MM: Create a new Route
        //--MM: GET@<vhostRoot>/interview/mmcgrath
        $this->add('interview/{lastname}', 'GET', [
            'controller'    => 'Interview',
            'action'        => 'index',
        ]);
    }
}
