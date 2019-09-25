<?php
//TODO :: Try to explain what is going on at the line below. 
//--MM: using PSR-0/4 to autoload a base controller class which is extended via this class.
//--MM: more in depth reguarding psr-0/4 in the routes file. 
namespace Shop\Site\Controllers;

class Product extends \Dsc\Controller
{
    //TODO :: Try to explain what is going on at the line below. 
    //--MM: Sometimes inheritence isnt appropriate. 
    //--MM: You may want to simply decorate a individual class with a few extra methods. 
    //--MM: Any methods exposed in "SupportPreview" are accessable with $this or self depending on the context. 
    use \Dsc\Traits\Controllers\SupportPreview;

    protected function model($type = null)
    {
        //TODO :: Try to explain what is going on at the line below. 
        //--MM: Since type is likely a scalar, I would guess it is coming in as a URL param. 
        //--MM: I actually built something simliar to this a few years back. 
        //--MM: I would guess \Dsc\Controller has a method called "model()" exposes an api.. 
        //--MM: ...to whatever persistence layer is being utilized. 
        //--MM: In orther words, I would guess this method isnt actually even called by the routes file, 
        //--MM: ...but by the packages method, and exposes an interface to the Database.
        switch (strtolower($type)) {
            case "products":
            case "product":
                $model = new \Shop\Models\Products;
                break;
            default:
                $model = new \Shop\Models\Categories;
                break;
        }

        return $model;
    }


    public function packages()
    {
        //--MM: Simple, clever. 
        $this->registerName(__METHOD__);

        //TODO :: Try to explain what is going on at the line below. 
        //--MM: Sanitize user input. Prevent web rascals from dropping your entire database with a deliberately placed semi-colon. 
        //--MM: looks like also some convenience methods to ensure stricter type checking of whats essentially user supplied input (Good!)
        $tracking = $this->inputfilter->clean($this->app->get('PARAMS.trackingnumber'), 'string');

        //--MM: Don't we not know if this is a product yet? 
        $model = new \Shop\Models\Products;
        $model->setCondition('tracking.model_number', strtoupper($tracking));

        //--MM: This is where the model method (above) is first called. 
        $item = $model->getItem();

        // if (empty($item->id)) {
        //     //TODO :: Try to explain what is going on at the line below. 
        //     $this->app->error('404', 'Invalid Product');
        // } else {
        //     $kits = $item->getKitsFromThisProduct();

        //--MM: Much better. return not necessary if it throws immediately. 
        if (empty($item)) {
            //--MM: I would guess, $app exposes an error method which throws an exception.
            //--MM: Somewhere else in the application is responsible for catching and trying to recover. 
            //--MM: The most simple extension of the native php Exception requires an error code (in this case an HTTP error code), and an error message. 
            return $this->app->error('404', 'Invalid Product');
        }

        $kits = $item->getKitsFromThisProduct();

        //TODO :: Try to explain what is going on at the line below. 
        //--MM: $app is most probably a global proxy to the container. 
        //--MM: eg. Global scope for this request lifecycle. 

        //TODO: explain a few problems with this approach.
        //--MM: If a product doesn't have kits the logic to handle will make this grow and grow. 
        //--MM: Honestly any business logic change will make it very messy. 
        //--MM: Changing meta requires making changes to the class that appears to be in charge of displaying all packages on the entire site. 
        //--MM: Good tests can help mitigate mistakes, but this would make me slightly nervous. 
        $this->app->set('meta.description', 'Save on these ' . count($kits) . ' packages that include ' . $item->title . ' Save with Free Shipping & Expert Jeep Advice');
        $this->app->set('meta.title', 'Packages Deals For ' . $item->title);

        //TODO :: What do you think is happening here? 
        //--MM: I would expect these calls to be hydrating view with $kits and $item data. 
        //--MM: That is, in the view, I would expect an $item and $kits array/object to be available.     
        $this->app->set('item', $item);
        $this->app->set('kits', $kits);

        //--MM: Decide on what version of the view to send back in the response based on something
        //--MM: .. That doesnt appear to be decided in the controller
        $view = \Dsc\System::instance()->get('theme');

        //--MM: $view object injected intro constructor of base controller class and exposes API for interacting/returning views?
        echo $view->render('Shop/Site/Views::product/packages.php');
    }
}
