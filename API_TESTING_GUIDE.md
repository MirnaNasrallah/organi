# Organi API Testing Guide

## Overview
This guide explains how to test the Organi API with the new Laravel Sanctum authentication system.

## Features
- **Simplified Registration**: Users register with only basic information (name, email, password)
- **Token-based Authentication**: Uses Laravel Sanctum for secure API access
- **Premium Features**: Additional profile information only available after premium upgrade
- **Role-based Access Control**: Different permissions for regular users vs premium users

## Quick Start

### 1. Import Postman Collection
1. Open Postman
2. Click "Import" button
3. Select the `postman_collection.json` file
4. The collection will be imported with all endpoints organized in folders

### 2. Set Environment Variables
The collection uses these variables:
- `base_url`: Set to `http://localhost:8000/api` (or your server URL)
- `token`: Will be automatically set after login

### 3. Update Base URL
If your Laravel server runs on a different port, update the `base_url` variable:
- Go to the collection variables
- Change `base_url` to match your server (e.g., `http://localhost:8080/api`)

## Testing Flow

### Step 1: Register a New User
**Endpoint**: `POST /api/register`

**Request Body**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response**:
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user",
    "subscription_status": "inactive"
  },
  "token": "1|abcdef123456..."
}
```

### Step 2: Login (Alternative to Registration)
**Endpoint**: `POST /api/login`

**Request Body**:
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

### Step 3: Copy Token
After registration or login, copy the `token` value and:
1. Go to the collection variables
2. Paste the token value into the `token` variable
3. Save the collection

### Step 4: Test Protected Endpoints
Now you can test protected endpoints:

- **Get Profile**: `GET /api/profile`
- **Get Current User**: `GET /api/user`

### Step 5: Test Premium Features

#### Upgrade to Premium
**Endpoint**: `POST /api/upgrade-premium`
- Requires authentication
- Automatically upgrades user to premium for 1 year

#### Update Profile (Premium Only)
**Endpoint**: `PATCH /api/profile`

**Request Body**:
```json
{
  "weight": 75.5,
  "height": 180.0,
  "age": 30,
  "gender": "male"
}
```

**Note**: This endpoint will return 403 Forbidden if user is not premium.

### Step 6: Logout
**Endpoint**: `POST /api/logout`
- Revokes the current token
- User needs to login again to get a new token

## Error Handling

### Common Response Codes
- `200`: Success
- `201`: Created (registration)
- `401`: Unauthorized (invalid credentials)
- `403`: Forbidden (premium required)
- `422`: Validation Error

### Sample Error Response
```json
{
  "message": "Validation errors",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password field is required."]
  }
}
```

## Testing Scenarios

### 1. Registration Flow
1. Register with valid data → Should return 201 with token
2. Register with same email → Should return 422 validation error
3. Register with invalid email → Should return 422 validation error
4. Register with short password → Should return 422 validation error

### 2. Login Flow
1. Login with valid credentials → Should return 200 with token
2. Login with invalid credentials → Should return 401 unauthorized
3. Login with missing fields → Should return 422 validation error

### 3. Premium Features Flow
1. Try to update profile as regular user → Should return 403 forbidden
2. Upgrade to premium → Should return 200 with updated user
3. Update profile as premium user → Should return 200 with updated data

### 4. Authentication Flow
1. Access protected endpoint without token → Should return 401
2. Access protected endpoint with invalid token → Should return 401
3. Access protected endpoint with valid token → Should return 200
4. Logout → Should return 200
5. Try to access protected endpoint after logout → Should return 401

## Collection Structure

```
📁 Organi API Authentication
├── 📁 Authentication
│   ├── Register User
│   ├── Login User
│   ├── Get User Profile
│   ├── Get Current User
│   └── Logout User
├── 📁 Premium Features
│   ├── Upgrade to Premium
│   └── Update Profile (Premium Only)
└── 📁 Other Endpoints
    ├── Get All Users
    ├── Get All Categories
    ├── Get All Products
    └── Get My Plan (Protected)
```

## Tips for Testing

1. **Use Environment Variables**: Always use `{{base_url}}` and `{{token}}` variables
2. **Test in Order**: Follow the flow from registration → login → premium upgrade → profile update
3. **Save Tokens**: After login, save the token to test protected endpoints
4. **Test Error Cases**: Try invalid data to test validation
5. **Check Response Status**: Always verify the HTTP status code matches expected behavior

## Troubleshooting

### Token Issues
- If you get 401 errors, ensure the token is correctly set in the collection variable
- Tokens are prefixed with a number (e.g., `1|abcdef123456...`)
- Make sure to include the full token string

### Server Issues
- Ensure Laravel server is running (`php artisan serve`)
- Check that migrations are run (`php artisan migrate`)
- Verify Sanctum is properly installed and configured

### Collection Issues
- Re-import the collection if endpoints are missing
- Check that base_url variable is correctly set
- Ensure Content-Type is set to `application/json` for POST requests

## Next Steps
After testing the basic authentication flow, you can:
1. Add more premium features
2. Implement email verification
3. Add password reset functionality
4. Create admin-specific endpoints
5. Add rate limiting for security 