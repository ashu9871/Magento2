    <?php
    use Magento\Framework\App\Bootstrap;
    require __DIR__ . '/app/bootstrap.php';
    $bootstrap = Bootstrap::create(BP, $_SERVER);
    $obj = $bootstrap->getObjectManager();
    $state = $obj->get('Magento\Framework\App\State');
    $state->setAreaCode('frontend');


    
    ini_set('display_errors', 1);
    echo "HELLO STACK EXCHANGE";


    echo "<pre>";
    $file = fopen('all_reviews.csv', 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        if($line[0]=='PRODUCT NAME')
            continue;

            $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $storeManager      = $_objectManager->create('Magento\Store\Model\StoreManagerInterface');
    
        $sku = $line[1];
        
        
        echo $product = $_objectManager->get('Magento\Catalog\Model\Product')->getIdBySku($sku);
     

        echo "<br>productId ".$productId = $product;
        echo "<br>customerId ".$customerId=13; //for Guest user $customerId=Null;
        echo "<br>customerNickName ". $customerNickName= $line[2];
        echo "<br>reviewTitle ". $reviewTitle= $line[3];
        echo "<br>reviewDetail ". $reviewDetail= $line[5];
        echo "<br>StoreId ". $StoreId=$storeManager->getStore()->getId();
        echo "<br>title ". $title= $line[3];

        $date =date('Y-m-d'); // current date
        echo "<br>Review_date ". $new_date_format = date('Y-m-d H:i:s', strtotime($date." -".rand(30,90)." days")); 


        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_review = $_objectManager->get("Magento\Review\Model\Review")
        ->setEntityPkValue($productId)    //product Id
        ->setStatusId(\Magento\Review\Model\Review::STATUS_PENDING)// pending/approved
        ->setTitle($reviewTitle)
        ->setDetail($reviewDetail)
        ->setEntityId(1)
        ->setStoreId($StoreId)
        ->setStores(1)
        ->setCustomerId($customerId)//get dynamically here 
        ->setNickname($customerNickName);

        //->save();
        echo "Review Has been saved ";
        $cacheManager = $_objectManager->get('\Magento\Framework\App\CacheInterface');
        $cacheManager->clean('catalog_product_' . $productId);
        echo "/////FOR SAVING RATING /////////
        ///////////////////////////////";

        /* 
        $_ratingOptions = array(
        1 => array(1 => 1,  2 => 2,  3 => 3,  4 => 4,  5 => 5),   //quality
        2 => array(1 => 6,  2 => 7,  3 => 8,  4 => 9,  5 => 10),  //value
        3 => array(1 => 11, 2 => 12, 3 => 13, 4 => 14, 5 => 15),  //price 
        4 => array(1 => 16, 2 => 17, 3 => 18, 4 => 19, 5 => 20)   //rating
        );*/

        //Lets Assume User Chooses Rating based on Rating Attributes called(quality,value,price,rating)
        $ratingOptions = array(
        '1' => rand(4,5),

        );      

        foreach ($ratingOptions as $ratingId => $optionIds) 
        {     
        $_objectManager->get("Magento\Review\Model\Rating")
        ->setRatingId($ratingId)
        ->setReviewId($_review->getId())
        ->addOptionVote($optionIds, $productId);

        }
        echo  "Latest REVIEW ID ===".$_review->getId()."</br>";     
        //$_review->aggregate();
        //$_review->aggregate()->setCreatedAt($new_date_format);
        $_review="";
        

       // break;
       
       sleep(5);
    }
    fclose($file);

    die("Scripts End");
    echo "Rating has been saved submitted  successfully";

    ?>