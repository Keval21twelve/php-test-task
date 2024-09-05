# PHP Test Task

This solution provides a basic structure for calculating basket totals with delivery and special offers in a straightforward PHP implementation.

## Assumptions

- The basket assumes valid product codes are passed when adding products.
- Special offers are applied at checkout.
- Delivery charges are calculated after discounts.

## Code Explanation

### 1. Product Catalog

```
$products = [
    'R01' => 32.95,
    'G01' => 24.95,
    'B01' => 7.95
];
```

### 2. Delivery Rules

```
function calculateDelivery($subtotal) {
    if ($subtotal >= 90) {
        return 0;
    } elseif ($subtotal >= 50) {
        return 2.95;
    } else {
        return 4.95;
    }
}
```

### 3. Special Offer Handling

For the red widget (R01), the offer gives the second unit at half price.

```
function applySpecialOffers($basket) {
    $redWidgetCount = 0;

    foreach ($basket as $code => $quantity) {
        if ($code == 'R01') {
            $redWidgetCount = $quantity;
        }
    }

    $discount = 0;

    // Apply the "Buy 1 Red Widget, get the second at half price" offer
    if ($redWidgetCount >= 2) {
        $discount = floor($redWidgetCount / 2) * (32.95 / 2);
    }

    return $discount;
}
```

### 4. Basket Functionality

```
class Basket {
    private $products;
    private $basket = [];

    public function __construct($products) {
        $this->products = $products;
    }

    public function add($productCode) {
        if (isset($this->basket[$productCode])) {
            $this->basket[$productCode]++;
        } else {
            $this->basket[$productCode] = 1;
        }
    }

    public function total() {
        $subtotal = 0;

        // Calculate subtotal
        foreach ($this->basket as $code => $quantity) {
            $subtotal += $this->products[$code] * $quantity;
        }

        // Apply special offers
        $discount = applySpecialOffers($this->basket);
        $subtotal -= $discount;

        // Calculate delivery
        $delivery = calculateDelivery($subtotal);

        return $subtotal + $delivery;
    }
}
```

### 5. Example Usage

```
$basket = new Basket($products);
$basket->add('R01');
$basket->add('R01');
$basket->add('B01');

echo "Total: $" . number_format($basket->total(), 2);
```
