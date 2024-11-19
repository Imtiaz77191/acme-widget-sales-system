# Basket Pricing System

This project implements a basket pricing system for Acme Widget Co. It calculates the total cost of a basket by considering product prices, delivery rules, and special offers.

---

## Features

- Add products to the basket using product codes.
- Apply delivery charges based on order subtotal:
  - Orders under $50: $4.95 delivery cost.
  - Orders under $90: $2.95 delivery cost.
  - Orders $90 or more: Free delivery.
- Special offer:
  - **Buy one Red Widget (R01), get the second one at half price.**

---

## Installation

### Prerequisites:
- PHP (7.4 or higher)
- Composer
- PHPUnit (installed via Composer)

### Steps:
1. Clone or copy the project files into your local server directory (e.g., `htdocs/test2/`).
2. Run the following command in the project root directory to install dependencies:
   ```bash
   composer install
