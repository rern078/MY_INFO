# Portfolio API Documentation

This API provides full CRUD (Create, Read, Update, Delete) operations for all tables in the portfolio system.

## Base URL
```
http://your-domain.com/api/api_submitter.php
```

## URL Format
All endpoints use the `table` parameter to specify which table to operate on:

```
http://your-domain.com/api/api_submitter.php?table=TABLE_NAME
```

## Authentication
Currently, the API doesn't require authentication, but it's recommended to implement it for production use.

## Response Format
All responses are in JSON format with the following structure:

**Success Response:**
```json
{
    "data": [...],
    "count": 5
}
```

**Error Response:**
```json
{
    "error": "Error message"
}
```

## Available Endpoints

### 1. Users Management

#### GET /api_submitter.php?table=users
Get all users
```bash
GET /api_submitter.php?table=users
```

#### GET /api_submitter.php?table=users&id=1
Get specific user by ID
```bash
GET /api_submitter.php?table=users&id=1
```

#### POST /api_submitter.php?table=users
Create a new user
```bash
POST /api_submitter.php?table=users
Content-Type: application/json

{
    "username": "newuser",
    "email": "user@example.com",
    "password": "password123"
}
```

#### PUT /api_submitter.php?table=users&id=1
Update user
```bash
PUT /api_submitter.php?table=users&id=1
Content-Type: application/json

{
    "email": "updated@example.com",
    "password": "newpassword"
}
```

#### DELETE /api_submitter.php?table=users&id=1
Delete user
```bash
DELETE /api_submitter.php?table=users&id=1
```

### 2. Personal Information

#### GET /api_submitter.php?table=personal_info
Get all personal info records
```bash
GET /api_submitter.php?table=personal_info
```

#### POST /api_submitter.php?table=personal_info
Create personal info
```bash
POST /api_submitter.php?table=personal_info
Content-Type: application/json

{
    "name": "John Doe",
    "title": "Software Developer",
    "email": "john@example.com",
    "phone": "+1234567890",
    "height": "175 cm",
    "weight": "70 kg",
    "date_of_birth": "1990-01-01",
    "gender": "Male",
    "nationality": "American",
    "marital_status": "Single",
    "religion": "None",
    "address": "123 Main St",
    "city": "New York",
    "state": "NY",
    "zip": "10001",
    "country": "USA",
    "location": "New York, USA"
}
```

### 3. Work Experience

#### GET /api_submitter.php?table=experience
Get all experience records
```bash
GET /api_submitter.php?table=experience
```

#### GET /api_submitter.php?table=experience&user_id=1
Get experience for specific user
```bash
GET /api_submitter.php?table=experience&user_id=1
```

#### POST /api_submitter.php?table=experience
Create experience record
```bash
POST /api_submitter.php?table=experience
Content-Type: application/json

{
    "user_id": 1,
    "title": "Senior Developer",
    "company": "Tech Corp",
    "start_date": "2020-01-01",
    "end_date": "2023-01-01",
    "is_current": 0,
    "description": "Led development team",
    "achievements": "Improved efficiency by 40%"
}
```

### 4. Education

#### GET /api_submitter.php?table=education
Get all education records
```bash
GET /api_submitter.php?table=education
```

#### GET /api_submitter.php?table=education&user_id=1
Get education for specific user
```bash
GET /api_submitter.php?table=education&user_id=1
```

#### POST /api_submitter.php?table=education
Create education record
```bash
POST /api_submitter.php?table=education
Content-Type: application/json

{
    "user_id": 1,
    "degree": "Bachelor of Science",
    "field_of_study": "Computer Science",
    "school": "University of Technology",
    "start_date": "2016-09-01",
    "end_date": "2020-05-31",
    "is_current": 0,
    "gpa": "3.85",
    "achievements": "Dean's List, Graduated with honors"
}
```

### 5. Skills

#### GET /api_submitter.php?table=skills
Get all skills
```bash
GET /api_submitter.php?table=skills
```

#### GET /api_submitter.php?table=skills&user_id=1
Get skills for specific user
```bash
GET /api_submitter.php?table=skills&user_id=1
```

#### POST /api_submitter.php?table=skills
Create skill record
```bash
POST /api_submitter.php?table=skills
Content-Type: application/json

{
    "user_id": 1,
    "skill_name": "JavaScript",
    "proficiency_level": "Expert",
    "category": "Programming Languages"
}
```

### 6. Social Media

#### GET /api_submitter.php?table=social_media
Get all social media records
```bash
GET /api_submitter.php?table=social_media
```

#### GET /api_submitter.php?table=social_media&user_id=1
Get social media for specific user
```bash
GET /api_submitter.php?table=social_media&user_id=1
```

#### POST /api_submitter.php?table=social_media
Create social media record
```bash
POST /api_submitter.php?table=social_media
Content-Type: application/json

{
    "user_id": 1,
    "platform": "LinkedIn",
    "username": "john-doe",
    "url": "https://linkedin.com/in/john-doe",
    "is_active": 1,
    "display_order": 1,
    "icon_class": "fab fa-linkedin"
}
```

### 7. Certificates

#### GET /api_submitter.php?table=certificates
Get all certificates
```bash
GET /api_submitter.php?table=certificates
```

#### POST /api_submitter.php?table=certificates
Create certificate record
```bash
POST /api_submitter.php?table=certificates
Content-Type: application/json

{
    "title": "AWS Certified Solutions Architect",
    "issuing_organization": "Amazon Web Services",
    "issue_date": "2023-06-15",
    "expiry_date": "2026-06-15",
    "credential_id": "AWS-123456789",
    "credential_url": "https://aws.amazon.com/verification",
    "file_path": "uploads/certificates/cert.pdf",
    "file_type": "pdf",
    "description": "Professional level certification"
}
```

### 8. Courses

#### GET /api_submitter.php?table=courses
Get all courses
```bash
GET /api_submitter.php?table=courses
```

#### GET /api_submitter.php?table=courses&user_id=1
Get courses for specific user
```bash
GET /api_submitter.php?table=courses&user_id=1
```

#### GET /api_submitter.php?table=courses&education_id=1
Get courses for specific education
```bash
GET /api_submitter.php?table=courses&education_id=1
```

#### POST /api_submitter.php?table=courses
Create course record
```bash
POST /api_submitter.php?table=courses
Content-Type: application/json

{
    "user_id": 1,
    "education_id": 1,
    "course_code": "CS101",
    "course_name": "Introduction to Programming",
    "course_description": "Basic programming concepts",
    "credits": 3,
    "grade": "A",
    "semester": "Fall",
    "academic_year": "2020-2021",
    "instructor": "Dr. Smith",
    "course_type": "Core"
}
```

### 9. Company Information

#### GET /api_submitter.php?table=company_info
Get all company info records
```bash
GET /api_submitter.php?table=company_info
```

#### POST /api_submitter.php?table=company_info
Create company info record
```bash
POST /api_submitter.php?table=company_info
Content-Type: application/json

{
    "name": "Tech Solutions Co., Ltd.",
    "position": "Senior Software Developer",
    "hiring_manager": "Mr. John Manager",
    "street": "456 Business Ave",
    "city": "New York",
    "state": "NY",
    "zip": "10001"
}
```

### 10. Cover Letter

#### GET /api_submitter.php?table=cover_letter
Get all cover letter records
```bash
GET /api_submitter.php?table=cover_letter
```

#### POST /api_submitter.php?table=cover_letter
Create cover letter record
```bash
POST /api_submitter.php?table=cover_letter
Content-Type: application/json

{
    "introduction": "I am writing to express my interest...",
    "body": "Throughout my career, I have developed...",
    "closing": "Thank you for considering my application..."
}
```

### 11. Languages

#### GET /api_submitter.php?table=languages
Get all language records
```bash
GET /api_submitter.php?table=languages
```

#### POST /api_submitter.php?table=languages
Create language record
```bash
POST /api_submitter.php?table=languages
Content-Type: application/json

{
    "name": "English",
    "proficiency": 5
}
```

### 12. Interests

#### GET /api_submitter.php?table=interests
Get all interest records
```bash
GET /api_submitter.php?table=interests
```

#### POST /api_submitter.php?table=interests
Create interest record
```bash
POST /api_submitter.php?table=interests
Content-Type: application/json

{
    "name": "Reading",
    "icon_class": "fas fa-book"
}
```

## HTTP Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `404` - Not Found
- `405` - Method Not Allowed
- `500` - Internal Server Error

## Error Handling

The API returns detailed error messages in JSON format:

```json
{
    "error": "Missing required field: username"
}
```

## Examples

### Using cURL

**Get all users:**
```bash
curl -X GET "http://your-domain.com/api/api_submitter.php?table=users"
```

**Create a new user:**
```bash
curl -X POST "http://your-domain.com/api/api_submitter.php?table=users" \
  -H "Content-Type: application/json" \
  -d '{
    "username": "newuser",
    "email": "user@example.com",
    "password": "password123"
  }'
```

**Update a user:**
```bash
curl -X PUT "http://your-domain.com/api/api_submitter.php?table=users&id=1" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "updated@example.com"
  }'
```

**Delete a user:**
```bash
curl -X DELETE "http://your-domain.com/api/api_submitter.php?table=users&id=1"
```

### Using JavaScript (Fetch API)

**Get all users:**
```javascript
fetch('http://your-domain.com/api/api_submitter.php?table=users')
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Error:', error));
```

**Create a new user:**
```javascript
fetch('http://your-domain.com/api/api_submitter.php?table=users', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    username: 'newuser',
    email: 'user@example.com',
    password: 'password123'
  })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

## Security Considerations

1. **Input Validation**: All inputs are sanitized and validated
2. **SQL Injection Protection**: Uses prepared statements
3. **Password Hashing**: Passwords are hashed using PHP's password_hash()
4. **CORS**: Configured to allow cross-origin requests
5. **Error Logging**: Errors are logged but not exposed to users

## Rate Limiting

Consider implementing rate limiting for production use to prevent abuse.

## File Upload

For file uploads (like certificates), you'll need to handle file uploads separately and store the file path in the database. 