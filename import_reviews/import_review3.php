<?php

    use Magento\Framework\App\Bootstrap;

    require __DIR__ . '/app/bootstrap.php';
    $bootstrap = Bootstrap::create(BP, $_SERVER);

	$_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$storeManager   = $_objectManager->create('Magento\Store\Model\StoreManagerInterface');
	$reviewFactory 	= $_objectManager->get("Magento\Review\Model\Review");
	$ratingFactory	= $_objectManager->get("Magento\Review\Model\Rating");


    $file = fopen('all_reviews.csv', 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        if($line[0]=='PRODUCT NAME')
            continue;
		$productId  = $_objectManager->get('Magento\Catalog\Model\Product')->getIdBySku($sku);
		echo "<br>productId ".$productId = $product;
        echo "<br>customerId ".$customerId=13; //for Guest user $customerId=Null;
        echo "<br>customerNickName ". $customerNickName= $line[2];
        echo "<br>reviewTitle ". $reviewTitle= $line[3];
        echo "<br>reviewDetail ". $reviewDetail= $line[5];
        echo "<br>StoreId ". $StoreId=$storeManager->getStore()->getId();
        echo "<br>title ". $title= $line[3];
		
        //$productId = 2047;//product id you set accordingly
        $reviewFinalData['ratings'][1] = rand(4,5);
        $reviewFinalData['ratings'][2] = rand(4,5);
        $reviewFinalData['ratings'][3] = rand(4,5);
        $reviewFinalData['nickname'] = $customerNickName;
        $reviewFinalData['title'] = $reviewTitle;
        $reviewFinalData['detail'] = $reviewDetail;
        $review = $reviewFactory->create()->setData($reviewFinalData);
        $review->unsetData('review_id');
        $review->setEntityId($review->getEntityIdByCode(\Magento\Review\Model\Review::ENTITY_PRODUCT_CODE))
            ->setEntityPkValue($productId)
            ->setStatusId(\Magento\Review\Model\Review::STATUS_APPROVED)//By default set approved
            ->setStoreId($this->_storeManager->getStore()->getId())
            ->setStores([$this->_storeManager->getStore()->getId()])
            ->save();

        foreach ($reviewFinalData['ratings'] as $ratingId => $optionId) {
            $ratingFactory->create()
                ->setRatingId($ratingId)
                ->setReviewId($review->getId())
                ->addOptionVote($optionId, $productId);
        }

        $review->aggregate();
    }
