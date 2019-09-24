<?php
namespace Shop\Site;
 //TODO :: what do you think is happening here.   
use Dsc\Mongo\Collection;

class Routes extends \Dsc\Routes\Group
{

    public function initialize()
    {
        $f3 = \Base::instance();
         //TODO :: what do you think is happening here.   
        $this->setDefaults( array(
            'namespace' => '\Shop\Site\Controllers',
            'url_prefix' => ''
        ) );
         //TODO :: what do you think is happening here.   
        $this->add( '/', 'GET', array(
            'controller' => 'Home',
            'action' => 'index'
        ) );

        $this->add( '/part/packages/@trackingnumber', 'GET', array(
            'controller' => 'Product',
            'action' => 'Packages'
        ) );

        /* LOTS OF ROUTES HAVE BEEN OMMITED */

         //TODO :: How do you think that this method differs from the above methods in this class?   
        $this->addCrudItem('Address', array(
            'namespace' => '\Shop\Site\Controllers',
            'url_prefix' => '/account/addresses'
        ));

        $this->add( '/account/addresses', 'GET|POST', array(
            'controller' => 'Address',
            'action' => 'index'
        ) );

        
    }
}
