# Laravel AI-Powered Product Recommendation System

A full-stack eCommerce project built with **Laravel 12** and **Python ML**, implementing an **Amazon-style product recommendation engine**. Users can browse products and get personalized recommendations based on their order history.

---

## Features

-   **User Authentication** via Laravel Sanctum
-   **Product & Order Management** with Laravel models, migrations, and seeders
-   **Massive Dataset Support**: Seeded with 20,000 users, 50,000 products, and 10,000+ orders
-   **AI-Powered Recommendations**: Uses Python ML with **SVD (Collaborative Filtering)** to generate personalized recommendations, stored in `recommendations.json`
-   **API Endpoint**: `/ml-recommendations` returns personalized products for authenticated users
-   **Scheduler Integration**: Daily regeneration of recommendations via Python script

---

## Tech Stack

-   **Backend:** Laravel 12, MySQL
-   **Frontend:** Optional (API ready for React/Next.js)
-   **Machine Learning:** Python 3, Pandas, Numpy, Scikit-learn
-   **Authentication:** Laravel Sanctum
-   **Deployment:** Local / Production-ready

---

## Project Structure

```
├─ app/
│  ├─ Models/ (User, Product, Order)
│  ├─ Services/MLRecommendationService.php
│  └─ Http/Controllers/ProductController.php
├─ storage/
│  ├─ orders.json
│  ├─ products.json
│  └─ recommendations.json
│─ ml_recommendation.py  # Python ML script
│─ venv/                # Optional virtual environment
└─ routes/api.php
```

---

## Setup Instructions

1. **Clone Repository**

```bash
git clone <repo-url>
cd laravel
```

2. **Install Laravel Dependencies**

```bash
composer install
php artisan migrate --seed
```

3. **Export Data for ML**

```bash
php artisan export:data
```

4. **Setup Python Environment & Run ML Script**

```bash
cd ai-tool
python3 -m venv venv
source venv/bin/activate
pip install pandas numpy scikit-learn
python3 ml_recommendation.py
```

-   Generates `storage/recommendations.json`

5. **Run Laravel Server**

```bash
php artisan serve
```

6. **Test API**

-   Authenticate user → call `/ml-recommendations` → get recommended products

---

## Notes

-   **Large Dataset Optimization:** Uses TruncatedSVD with sparse matrices for performance (handles 20k users × 50k products efficiently)
-   **Scheduler Integration:** Regenerate recommendations daily using Laravel Scheduler
-   **SonarQube Compliant:** Python code uses `np.nonzero` for index extraction
