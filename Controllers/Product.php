<?php
//TODO :: Try to explain what is going on at the line below. 
namespace Shop\Site\Controllers;

class Product extends \Dsc\Controller
{   
    //TODO :: Try to explain what is going on at the line below. 
	use \Dsc\Traits\Controllers\SupportPreview;

    protected function model($type=null)
    {   
        //TODO :: Try to explain what is going on at the line below. 
        switch (strtolower($type))
        {
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
    

    public function packages() {
        $this->registerName(__METHOD__);


        //TODO :: Try to explain what is going on at the line below. 
        $tracking = $this->inputfilter->clean( $this->app->get('PARAMS.trackingnumber'), 'string' );

        $model = new \Shop\Models\Products;
        $model->setCondition('tracking.model_number',strtoupper($tracking));
        $item = $model->getItem();

        if (empty($item->id)) {
            //TODO :: Try to explain what is going on at the line below. 
    			$this->app->error( '404', 'Invalid Product' );
    	} else {
    	    $kits = $item->getKitsFromThisProduct();

            //TODO :: Try to explain what is going on at the line below. BONUS POINTS :: explain a few problems with this approach . 
    	    $this->app->set('meta.description', 'Save on these '. count($kits) . ' packages that include ' . $item->title. ' Save with Free Shipping & Expert Jeep Advice' );
    	    $this->app->set('meta.title', 'Packages Deals For '. $item->title);

            //TODO :: what do you think is happening here.     
    	    $this->app->set('item', $item );
    	    $this->app->set('kits', $kits );

    	    $view = \Dsc\System::instance()->get('theme');
    	    echo $view->render('Shop/Site/Views::product/packages.php');
    	}

    }

}