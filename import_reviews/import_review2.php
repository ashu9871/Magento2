    <?php
    use Magento\Framework\App\Bootstrap;

    require __DIR__ . '/app/bootstrap.php';
    $bootstrap = Bootstrap::create(BP, $_SERVER);


   
    

    $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $resource = $_objectManager->get('Magento\Framework\App\ResourceConnection');
    $connection =  $resource->getConnection();
    $tablename = $connection->getTableName('sales_order');
    
    ini_set('display_errors', 1);
    echo "HELLO STACK EXCHANGE";


    echo "<pre>";
    $file = fopen('all_reviews.csv', 'r');
    $i=1;
    while (($line = fgetcsv($file)) !== FALSE) {
        if($line[0]=='PRODUCT NAME')
            continue;

          
           

            echo "<br>".$sku = $line[1];
            //$query = "Sql Query";
            //$connection->query($query);
             $product = $_objectManager->get('Magento\Catalog\Model\Product')->getIdBySku($sku);

            echo "<br>PRODUCT_ID ".$PRODUCT_ID = $product;
            echo "<br>CUSTOMER_ID ".$CUSTOMER_ID=13; //for Guest user $customerId=Null;
            echo "<br>REVIEW_NICKNAME ". $REVIEW_NICKNAME= $line[2];
            echo "<br>REVIEW_TITLE ". $REVIEW_TITLE= addslashes(trim($line[3]));
            echo "<br>REVIEW_DETAIL ". $REVIEW_DETAIL= addslashes(trim($line[5]));
            echo "<br>REVIEW_RATING ". $REVIEW_RATING 		= rand(4,5); //-- Between 1 to 5
            echo "<br>STORE_ID ". $STORE_ID=1;
            echo "<br>REVIEW_ENTITY_ID ". $REVIEW_ENTITY_ID   = 1;
            echo "<br>REVIEW_STATUS_ID ". $REVIEW_STATUS_ID =1;

            $date =date('Y-m-d'); // current date
            echo "<br>Review_date ". $REVIEW_CREATED_AT = date('Y-m-d', strtotime($date." -".rand(30,90)." days")); 


            /*SET @PRODUCT_ID 		= 123;
            SET @STORE_ID 			= 1;
            SET @CUSTOMER_ID 		= NULL;
            SET @REVIEW_TITLE 		= 'Lorem Ipsum';
            SET @REVIEW_DETAIL 		= 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...';
            SET @REVIEW_RATING 		= 5; -- Between 1 to 5
            SET @REVIEW_NICKNAME 	= 'John Doe';
            SET @REVIEW_CREATED_AT 	= '2019-07-15'; -- OR date in YY-mm-dd HH:ii:ss format
            */
            
            echo "<br>".$sql1 = "INSERT INTO review SET created_at = '$REVIEW_CREATED_AT', 
                    entity_id = $REVIEW_ENTITY_ID, entity_pk_value = $PRODUCT_ID, 
                    status_id = $REVIEW_STATUS_ID";
            //SET @REVIEW_ID =  (SELECT LAST_INSERT_ID());
            $connection->query($sql1);
            echo "<br>REVIEW_ID ".$REVIEW_ID = $connection->lastInsertId(); 
            echo "<br>".$sql2 = "INSERT INTO review_detail SET review_id = $REVIEW_ID, store_id = $STORE_ID, 
            title = '$REVIEW_TITLE', detail = '$REVIEW_DETAIL',	nickname = '$REVIEW_NICKNAME', 
            customer_id = $CUSTOMER_ID";
            $connection->query($sql2);
            echo "<br>".$sql21 = "INSERT INTO review_store SET review_id = $REVIEW_ID, store_id = 0";
            $connection->query($sql21);
            echo "<br>".$sql3 = "INSERT INTO review_store SET review_id = $REVIEW_ID, store_id = $STORE_ID";
            $connection->query($sql3);
            echo "<br>".$sql4="INSERT INTO rating_option_vote SET option_id = 5, remote_ip = '', remote_ip_long = 0,
             customer_id = $CUSTOMER_ID, entity_pk_value = $PRODUCT_ID, rating_id = $REVIEW_ENTITY_ID,
            review_id = $REVIEW_ID, percent = 100, value = $REVIEW_RATING";
        $connection->query($sql4);
        
       
        $i++;
    }
    fclose($file);

    die("Scripts End");
    echo "Total $i Rating has been saved submitted  successfully";

    ?>