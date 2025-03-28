# Test Case Project

## 📌 Overview
This project is a test case implementation using PHPUnit to validate the discount calculation and total price calculation for a shopping basket.

## 🛠 Requirements
- **PHP 8.1+**
- **Composer**
- **Docker (Optional, if using containers)**
- **PHPUnit 10.5.45**

## 🚀 Installation
1. **Clone the repository:**
   ```sh
   git clone https://github.com/your-repo/test-case-project.git
   cd test-case-project
   ```

2. **Install dependencies:**
   ```sh
   composer install
   ```

3. **Run Docker container (if applicable):**
   ```sh
   docker-compose up -d
   docker exec -it <container_id> sh
   ```

## 🏃 Running Tests
To execute PHPUnit tests, run:
```sh
vendor/bin/phpunit tests/BasketTest.php
```
For detailed output:
```sh
vendor/bin/phpunit --debug
```

## 🛠 Debugging Calculation
To manually check calculations, run:
```sh
php test_discount.php
```

## 🔍 Expected Values
| Products | Subtotal | Expected Discount | Expected Final Total |
|----------|----------|------------------|------------------|
| `['B01', 'G01']` | **37.85** | **0.00** | **37.85** |
| `['R01', 'R01']` | **65.90** | **16.48** | **49.42** |
| `['R01', 'G01']` | **57.90** | **0.00** | **57.90** |
| `['B01', 'B01', 'R01', 'R01', 'R01']` | **146.75** | **16.48** | **130.27** |

## 📂 Project Structure
```
├── src/
│   ├── Basket.php  # Main basket logic
│   ├── Offer/
│   │   ├── BuyOneGetSecondHalfPrice.php
│   └── ...
├── tests/
│   ├── BasketTest.php  # PHPUnit tests
│   └── ...
├── test_discount.php  # Manual calculation test script
├── composer.json
├── phpunit.xml
└── README.md
```

## 📌 Troubleshooting
1. **PHPUnit not found?**
   ```sh
   composer require --dev phpunit/phpunit
   ```
2. **Docker container not running?**
   ```sh
   docker ps
   ```
3. **Calculation mismatch?**
   - Run `php test_discount.php` to debug manually.
   - Add `error_log()` in `calculateDiscount()` to check values.

## 📜 License
MIT License

