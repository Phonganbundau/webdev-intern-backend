# Webdev Intern Backend - Exam Score API

## Overview

This is the **backend** of the Exam Score Lookup web application, built with **Laravel**.  
It provides APIs to:

- Look up candidate scores by candidate ID (`sbd`)
- Get score statistics by subject
- Retrieve the top 10 candidates in Block A (Math, Physics, Chemistry)

This backend was developed as part of the code test for the **Web Developer Intern** position at **Golden Owl Solutions**.

Link to frontend github: https://github.com/Phonganbundau/webdev-intern-frontend

---

## Features

- **Candidate Score Lookup:**  
  API to search scores by 6-digit candidate ID.

- **Score Statistics:**  
  Count of candidates in each score range (>=8, 6–7.99, 4–5.99, <4) for each subject.

- **Top 10 Block A Candidates:**  
  Get the top 10 highest total scores in Math, Physics, and Chemistry.

- **Caching Support:**  
  Statistics results are cached for 1 hour to improve performance.

---

## Tech Stack

- **Framework:** Laravel 10  
- **Database:** MySQL  
- **ORM:** Eloquent  
- **Deployment:** Railway  
- **API Format:** JSON (RESTful)

---

## API Endpoints

| Method | Endpoint                | Description                               |
|--------|-------------------------|-------------------------------------------|
| GET    | `/api/diem-thi/tra-cuu/{sbd}`     | Get scores by candidate ID                |
| GET    | `/api/diem-thi/thong-ke`       | Get score statistics for all subjects     |
| GET    | `/api/diem-thi/top10-khoi-a`    | Get top 10 candidates in Block A          |

---

## Getting Started

### Prerequisites

- PHP >= 8.1  
- Composer  
- MySQL  
- Laravel CLI (optional)

Install dependencies:

```bash
composer install
```

Generate app key:

```bash
php artisan key:generate
```

Run database migration and seeding (if applicable):
```bash
php artisan migrate --seed
```

Run development server:
```
php artisan serve
```
The app will be available at: http://localhost:8000

### Deployment

The backend is deployed on Railway:
🔗 Live API:
[https://webdev-intern-backend-production.up.railway.app](https://webdev-intern-backend-production.up.railway.app/)



