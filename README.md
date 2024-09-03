## SnowHub API Documentation
The following is an api that manages information about the snow resorts of Greece

## Base URL
The base URL for accessing the SnowHub API is:https://www.snowhub.gr/api/
## Endpoints

### 1. Get Snow Resorts
Retrieve the details of all snow resorts.

- **Endpoint:** `GET /SnowResorts`
- **URL:** `/SnowResorts`
- **Response:**
    ```json
    [
        {
            "id": 2,
            "name": {
                "el": "Χ.Κ. Πηλίου",
                "en": "pilio"
            },
            "description": "Tο Χιονοδρομικό Κέντρο Πηλίου Αγριόλευκες...",
            "created_at": null,
            "updated_at": null,
            "location": "Πήλιο",
            "slopes_map": "39.38661281127292, 23.083438074693607",
            "site": "-",
            "status": "Closed",
            "activities": {
                "en": [
                    {
                        "id": 12,
                        "created_at": null,
                        "updated_at": null,
                        "snow_resort_id": 2,
                        "activity": "ski",
                        "language": "en"
                    },
                    ...
                ],
                "el": [
                    {
                        "id": 11,
                        "created_at": null,
                        "updated_at": null,
                        "snow_resort_id": 2,
                        "activity": "σκι",
                        "language": "el"
                    },
                    ...
                ]
            },
            "slopes": [
                {
                    "id": 22,
                    "created_at": null,
                    "updated_at": null,
                    "snow_resort_id": 2,
                    "name": "Πανόραμα1 Πίστα",
                    "difficulty": "red",
                    "length_m": 1050,
                    "altitude_m": 0,
                    "average_slope_percent": "0.00",
                    "details": "-"
                },
                ...
            ],
            "images": [
                {
                    "id": 2,
                    "created_at": null,
                    "updated_at": null,
                    "snow_resort_id": 2,
                    "caption": "view",
                    "image_url": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5FN6VMD98vZ3p7okawayeRigOs4l_NXJ79w&s"
                }
            ],
            "elevation": {
                "base": 1300,
                "peak": 1471
            }
        },
        ...
    ]
    ```
    - **Example Request:**

    ```bash
    curl -X GET https://www.snowhub.gr/api/SnowResorts
    ```

### 2. Get Lifts for a Specific Snow Resort
Retrieve the list of lifts for a specific snow resort.

- **Endpoint:** `GET /lifts/{snowResortId}`
- **URL:** `/lifts/{snowResortId}`
- **Path Parameters:**
    - `snowResortId` (integer): The ID of the snow resort.
- **Response:**
    ```json
    [
        {
            "id": 1990,
            "snow_resort_id": 2,
            "name": "Πήλιο 1(1-θέσιος Εναέριος)",
            "is_open": 0,
            "date": "2024-09-02",
            "created_at": "2024-09-02T20:21:00.000000Z",
            "updated_at": "2024-09-02T20:21:00.000000Z"
        },
        {
            "id": 1991,
            "snow_resort_id": 2,
            "name": "Πήλιο 2(1-θέσιος Εναέριος)",
            "is_open": 0,
            "date": "2024-09-02",
            "created_at": "2024-09-02T20:21:00.000000Z",
            "updated_at": "2024-09-02T20:21:00.000000Z"
        },
        ...
    ]
    
    ```
    - **Example Request:**

    ```bash
    curl -X GET https://www.snowhub.gr/api/lifts/{snowResortId}
    ```
    
  ### 3.Register a New User
Create a new user account.

- **Endpoint:** `POST /register`
- **URL:** `/register`
- **Headers:**
    - `Content-Type: application/json`
    - `Authorization: Bearer your_generated_token`
- **Request Body:**
    ```json
    {  
    "name":  "john",  
    "email":  "john12@gmail.com",  
    "password":  "password" 
     }
    ```
- **Response:**
    ```json
    {
        "message": "User registered successfully",
    }
    ```

- **Example Request:**

    ```bash
    curl -X POST https://www.snowhub.gr/api/register \
    -H "Content-Type: application/json" \
    -H "Authorization: Bearer your_generated_token" \
    -d '{
        "name": "John Doe",
        "email": "user@example.com",
        "password": "yourpassword",
    }'
    ```
    ### 4. User Login
Authenticate a user and retrieve a Bearer token.

- **Endpoint:** `POST /login`
- **URL:** `/login`
- **Headers:**
    - `Content-Type: application/json`
- **Request Body:**
    ```json
    {
        "email": "user@example.com",
        "password": "yourpassword"
    }
    ```
- **Response:**
    ```json
    {
        "token": "your_generated_token"
    }
    ```

- **Example Request:**

    ```bash
    curl -X POST https://www.snowhub.gr/api/login \
    -H "Content-Type: application/json" \
    -d '{"email": "user@example.com", "password": "yourpassword"}'
    ```
    ### 5.Logout User
Log out the authenticated user and invalidate the Bearer token.

- **Endpoint:** `POST /logout`
- **URL:** `/logout`
- **Headers:**
    - `Authorization: Bearer your_generated_token`
- **Response:**
    ```json
    {
        "message": "User logged out successfully."
    }
    ```

- **Example Request:**

    ```bash
    curl -X POST https://www.snowhub.gr/api/logout \
    -H "Authorization: Bearer your_generated_token"
    ```
### 5.Create a Booking
buy pass from user

- **Endpoint:** `POST /booking`
- **URL:** `/booking`
- **Headers:**
    - `Content-Type: application/json`
    - `Authorization: Bearer your_generated_token`
- **Request Body:**
    ```json
    {
        "snow_resort_id": 1,
        "cost": 13,
        "number_pass": 2
    }
    ```
- **Response:**
    ```json
    {
        "message": "Bookings created successfully",
    "bookings": [
        {
            "snow_resort_id": 1,
            "user_id": 4,
            "order_time": "2024-09-03T09:19:23.218906Z",
            "updated_at": "2024-09-03T09:19:23.000000Z",
            "created_at": "2024-09-03T09:19:23.000000Z",
            "id": 28
        },
        {
            "snow_resort_id": 1,
            "user_id": 4,
            "order_time": "2024-09-03T09:19:23.998001Z",
            "updated_at": "2024-09-03T09:19:23.000000Z",
            "created_at": "2024-09-03T09:19:23.000000Z",
            "id": 29
        }
    ]
    }
    ```

- **Example Request:**

    ```bash
    curl -X POST https://www.snowhub.gr/api/booking \
    -H "Content-Type: application/json" \
    -H "Authorization: Bearer your_generated_token" \
    -d '{
        "snow_resort_id": 1,
        "cost": 13,
        "number_pass": 2
    }'
    ```
    ### 6.Get My Bookings
Retrieve the list of bookings made by the authenticated user.

- **Endpoint:** `GET /mybooking`
- **URL:** `/mybooking`
- **Headers:**
    - `Authorization: Bearer your_generated_token`
- **Response:**
    ```json
    [
    {
        "id": 1,
        "created_at": "2024-08-16T13:58:05.000000Z",
        "updated_at": "2024-08-16T13:58:05.000000Z",
        "snow_resort_id": 1,
        "user_id": 4,
        "order_time": "13:58:05"
    },
    {
        "id": 2,
        "created_at": "2024-08-16T14:30:16.000000Z",
        "updated_at": "2024-08-16T14:30:16.000000Z",
        "snow_resort_id": 1,
        "user_id": 4,
        "order_time": "14:30:16"
    },
    {
        "id": 20,
        "created_at": "2024-08-30T09:48:24.000000Z",
        "updated_at": "2024-08-30T09:48:24.000000Z",
        "snow_resort_id": 1,
        "user_id": 4,
        "order_time": "09:48:24"
    }
    ]
    ```

- **Example Request:**

    ```bash
    curl -X GET https://www.snowhub.gr/api/mybooking \
    -H "Authorization: Bearer your_generated_token"
    ```
    
### 7.Get Authenticated User
Retrieve the details of the authenticated user.

- **Endpoint:** `GET /user`
- **URL:** `/user`
- **Headers:**
    - `Authorization: Bearer your_generated_token`
- **Response:**
    ```json
    {
        
    "id": 4,
    "name": "john",
    "email": "john@gmail.com",
    "email_verified_at": null,
    "created_at": "2024-08-14T16:19:48.000000Z",
    "updated_at": "2024-08-14T16:19:48.000000Z"
    }
    ```

- **Example Request:**

    ```bash
    curl -X GET https://www.snowhub.gr/api/user \
    -H "Authorization: Bearer your_generated_token"
    ```
### 8.Get All Slopes
Retrieve the list of all slopes available across snow resorts.

- **Endpoint:** `GET /slopes`
- **URL:** `/slopes`
- **Headers:** None required

- **Response:**
    ```json
    [
         {
        "id": 1,
        "created_at": null,
        "updated_at": null,
        "snow_resort_id": 1,
        "name": "Αφροδίτη Α (No 1) Πίστα",
        "difficulty": "red",
        "length_m": 800,
        "altitude_m": 1950,
        "average_slope_percent": "25.00",
        "details": "-"
    },
    {
        "id": 2,
        "created_at": null,
        "updated_at": null,
        "snow_resort_id": 1,
        "name": "Αίολος (No 4) Πίστα",
        "difficulty": "blue",
        "length_m": 800,
        "altitude_m": 2100,
        "average_slope_percent": "19.00",
        "details": "-"
    }
        // Additional slope objects...
    ]
    ```

- **Example Request:**

    ```bash
    curl -X GET https://www.snowhub.gr/api/slopes
    ```
    ### Get All Images
Retrieve the list of all images available across snow resorts.

- **Endpoint:** `GET /images`
- **URL:** `/images`
- **Headers:** None required

- **Response:**
    ```json
    [
        
        "id": 1,
        "created_at": null,
        "updated_at": null,
        "snow_resort_id": 1,
        "caption": "map",
        "image_url": "https://parnassos-ski.gr/wp-content/uploads/2022/01/Map_Parnassos-2022-scaled.jpg"
    },
    {
        "id": 2,
        "created_at": null,
        "updated_at": null,
        "snow_resort_id": 2,
        "caption": "view",
        "image_url": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5FN6VMD98vZ3p7okawayeRigOs4l_NXJ79w&s"
    }
        // Additional image objects...
    ]
    ```

- **Example Request:**

    ```bash
    curl -X GET https://www.snowhub.gr/api/images
    ```

### 9.Get Snow Resort by ID
Retrieve details of a specific snow resort by its ID.

- **Endpoint:** `GET /SnowResort/{snowResortId}`
- **URL:** `/SnowResort/{snowResortId}`
- **Headers:** None required

- **Response:**
    ```json
    {
         "id": 2,
    "name": "false",
    "description": "Tο Χιονοδρομικό Κέντρο Πηλίου Αγριόλευκες απέχει 2χλμ. από τον οικισμό των Χανίων Πηλίου, 8 χλμ. από τον οικισμό του Αγ. Λαυρεντίου και 27 χλμ. από το Βόλο. Το Χιονοδρομικό Κέντρο αναπτύσσεται στο βουνό του Πηλίου σε υψόμετρο 1471 μ., υψόμετρο το οποίο είναι εκπληκτικά χαμηλό για χιονοδρομικό κέντρο και του προσδίδει ιδιαιτερότητες στην χιονόπτωση, τη μορφολογία του εδάφους αλλά και το κλίμα. Υπάρχουν 5 πίστες συνολικού μήκους 15χλμ: 4 κύριες πίστες για σκι καταβάσεων εγκεκριμένες από τη Διεθνή Ομοσπονδία Χιονοδρομίας (FIS) 1 πίστα δρόμου αντοχής (Lang-Lauf), μήκους 5 χλμ., μοναδική για το φυσικό της περιβάλλον καθώς η κατάβαση γίνεται ανάμεσα σε οξιές, αγριόλευκες, καστανιές και θέα στο Αιγαίο. Το Χιονοδρομικό κέντρο διαθέτει 3 χώρους στάθμευσης για περισσότερα από 800 αυτοκίνητα, καταφύγιο, αναψυκτήριο, εστιατόριο, ενοικιάσεις -πωλήσεις εξοπλισμού ειδών ski & snowboard και φυσικά ιατρείο. Λειτουργεί επίσης σχολή σκι και snowboard με ειδικά τμήματα για παιδιά 3 χρονών και άνω από έμπειρους παιδαγωγούς δασκάλους.",
    "created_at": null,
    "updated_at": null,
    "name_en": "pilio",
    "name_el": "Χ.Κ. Πηλίου",
    "location": "Πήλιο",
    "elevation_base": 1300,
    "elevation_peak": 1471,
    "slopes_map": "39.38661281127292, 23.083438074693607",
    "site": "-",
    "status": "Closed"
    }
    ```

- **Example Request:**

    ```bash
    curl -X GET https://www.snowhub.gr/api/SnowResort/2
    ```
    ### 10.Get Cost Information for a Snow Resort
Retrieve the cost information for a specific snow resort by its ID.

- **Endpoint:** `GET /cost/{snowResortId}`
- **URL:** `/cost/{snowResortId}`
- **Headers:** None required

- **Response:**
    ```json
    {
        "id": 1,
        "created_at": null,
        "updated_at": null,
        "snow_resort_id": 1,
        "type": "kanoniko",
        "cost": 13
    }
    ```

- **Example Request:**

    ```bash
    curl -X GET https://www.snowhub.gr/api/cost/2
    ```
