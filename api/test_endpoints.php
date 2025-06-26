<?php
header('Content-Type: text/plain');

echo "API Endpoint Testing Script\n";
echo "==========================\n\n";

$base_url = "http://10.0.0.89:2002/api/api_submitter.php";

echo "1. GET all personal_info records:\n";
echo "curl -X GET '$base_url?table=personal_info'\n\n";

echo "2. GET specific personal_info record (ID=1):\n";
echo "curl -X GET '$base_url?table=personal_info&id=1'\n\n";

echo "3. UPDATE personal_info record (ID=1):\n";
echo "curl -X PUT '$base_url?table=personal_info&id=1' \\\n";
echo "  -H 'Content-Type: application/json' \\\n";
echo "  -d '{\n";
echo "    \"name\": \"Updated Name\",\n";
echo "    \"title\": \"Updated Title\",\n";
echo "    \"email\": \"updated@example.com\"\n";
echo "  }'\n\n";

echo "4. DELETE personal_info record (ID=1):\n";
echo "curl -X DELETE '$base_url?table=personal_info&id=1'\n\n";

echo "5. CREATE new personal_info record:\n";
echo "curl -X POST '$base_url?table=personal_info' \\\n";
echo "  -H 'Content-Type: application/json' \\\n";
echo "  -d '{\n";
echo "    \"name\": \"Test User\",\n";
echo "    \"title\": \"Software Developer\",\n";
echo "    \"email\": \"test@example.com\",\n";
echo "    \"phone\": \"+1234567890\",\n";
echo "    \"height\": \"175 cm\",\n";
echo "    \"weight\": \"70 kg\",\n";
echo "    \"date_of_birth\": \"1990-01-01\",\n";
echo "    \"gender\": \"Male\",\n";
echo "    \"nationality\": \"American\",\n";
echo "    \"marital_status\": \"Single\",\n";
echo "    \"religion\": \"None\",\n";
echo "    \"address\": \"123 Main St\",\n";
echo "    \"city\": \"New York\",\n";
echo "    \"state\": \"NY\",\n";
echo "    \"zip\": \"10001\",\n";
echo "    \"country\": \"USA\",\n";
echo "    \"location\": \"New York, USA\"\n";
echo "  }'\n\n";

echo "6. Test Users endpoints:\n";
echo "GET all users: curl -X GET '$base_url?table=users'\n";
echo "UPDATE user (ID=1): curl -X PUT '$base_url?table=users&id=1' -H 'Content-Type: application/json' -d '{\"username\":\"updateduser\",\"email\":\"updated@example.com\"}'\n";
echo "DELETE user (ID=1): curl -X DELETE '$base_url?table=users&id=1'\n\n";

echo "Note: Replace the IP address and port with your actual server details.\n";
echo "Make sure to test with existing record IDs that actually exist in your database.\n";
