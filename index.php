<!doctype html>
<html lang="en">

<head>
  <title>PHP Test Task</title>
</head>

<body>

<?php

function calculateDelivery( $subtotal ) {
    if ( $subtotal >= 90 ) {
        return 0;
    } elseif ( $subtotal >= 50 ) {
        return 2.95;
    } else {
        return 4.95;
    }
}

function applySpecialOffers( $basket ) {
    $redWidgetCount = 0;

    foreach ( $basket as $code => $quantity ) {
        if ( $code == 'R01' ) {
            $redWidgetCount = $quantity;
        }
    }

    $discount = 0;

    // Apply the 'Buy 1 Red Widget, get the second at half price' offer
    if ( $redWidgetCount >= 2 ) {
        $discount = floor( $redWidgetCount / 2 ) * ( 32.95 / 2 );
    }

    return $discount;
}

class Basket {
    private $products;
    private $basket = [];

    public function __construct( $products ) {
        $this->products = $products;
    }

    public function add( $productCode ) {
        if ( isset( $this->basket[ $productCode ] ) ) {
            $this->basket[ $productCode ]++;
        } else {
            $this->basket[ $productCode ] = 1;
        }
    }

    public function total() {
        $subtotal = 0;

        // Calculate subtotal
        foreach ( $this->basket as $code => $quantity ) {
            $subtotal += $this->products[ $code ] * $quantity;
        }

        // Apply special offers
        $discount = applySpecialOffers( $this->basket );
        $subtotal -= $discount;

        // Calculate delivery
        $delivery = calculateDelivery( $subtotal );

        return $subtotal + $delivery;
    }
}

$products = [
    'R01' => 32.95,
    'G01' => 24.95,
    'B01' => 7.95
];

$basket = new Basket( $products );
$basket->add( 'R01' );
$basket->add( 'R01' );
$basket->add( 'B01' );

echo "<h1>Total: $" . number_format( $basket->total(), 2 ) . '</h1>';

?>

</body>

</html>
