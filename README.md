## Overview

Satin.Sweets is an online store for a florist brand, covering the full path 
from browsing to a placed order.

Customers can browse products by category, open detail pages with images and 
descriptions, add items to a cart and complete checkout. Discount codes are 
validated on the server against eligibility and usage rules rather than in 
the browser, so a code cannot be reused or forged from the client side.

The owner manages the store through a separate admin area: adding and editing 
products, uploading images, adjusting stock and reviewing incoming orders — 
no database access required.

## Features

**Storefront**
- Categorised product catalogue with detail pages
- Cart with quantity handling
- Checkout flow with [order confirmation / email notification]
- Discount codes with server-side validation

**Admin**
- Product CRUD with image upload
- Stock management
- Order listing and status updates

**Engineering**
- Vue.js SPA served by a Laravel API, bundled with Vite
- ESLint + Prettier enforced from the first commit
- PHPUnit configured for backend tests
- Environment config via `.env.example`, no secrets committed
