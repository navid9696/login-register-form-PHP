
# Project: PHP Form Validation and Redirection

## Overview
This project is a simple PHP-based web application that includes a user login and registration form with validation functionality. It utilizes an `.htaccess` file to handle URL rewrites for clean URLs and redirects. 

### Key Features:
- User-friendly form validation for login and registration.
- Clear and detailed error messages for user input validation.
- URL rewriting for clean and SEO-friendly links.
- Basic redirection from the main page to the login form.

---

## File Structure

### 1. `index.php`
- **Purpose:** 
  - Redirects users from the root page to the `/login` page.

### 2. `login.php`
- **Purpose:** 
  - Displays the login form for users.
  - Validates the provided username and password.
  - Redirects users to the other site upon successful login.

- **Key Functionalities:**
  - Accepts username and password input.
  - Handles error messages for incorrect or missing login credentials.

### 3. `register.php`
- **Purpose:** 
  - Displays the registration form for new users.
  - Validates input for username, password, and password confirmation.
  - Ensures username uniqueness.

- **Key Functionalities:**
  - Ensures the password and confirm password match.
  - Displays validation errors for missing or invalid input.

### 4. `validationForm.php`
- **Purpose:** 
  - Contains the logic for form validation, supporting both login and registration contexts.
- **Key Functionalities:**
  - Validates the username, password, and password confirmation.
  - Returns user-friendly error messages for missing or invalid input.
  - Ensures passwords meet a minimum length of 6 characters.
  - Compares `password` and `confirm_password` during registration to ensure they match.

### 5. `.htaccess`
- **Purpose:**
  - Manages URL rewriting to make links cleaner and user-friendly.
  - Handles redirections and supports requests to PHP files without including the `.php` extension.
- **Key Directives:**
  - Removes `.php` from URLs.
  - Redirects `/app/` URLs to the root directory.
  - Adds implicit `.php` extension handling.

---

## Usage Instructions
1. Navigate to `http://localhost/` to be redirected to the `/login` page.
2. Use the login form for user authentication or registration form for new user signup.
3. Any missing or incorrect input will trigger validation messages.

