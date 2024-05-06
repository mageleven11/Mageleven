<?php
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();
$product = $objectManager->get('Magento\Framework\Registry')->registry('current_product');

if ($product && method_exists($product, 'getBackendDemo')) {
    $backendDemo = $product->getBackendDemo();
    if ($backendDemo) {
        header("Location: " . $backendDemo);
        exit;
    }
}

// Redirect to a default page if no backend demo URL is available
header("Location: /"); // You can change this URL to redirect to a different page
exit;
?>
