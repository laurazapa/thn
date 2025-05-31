# Feature: Get Hotel Details
# This feature tests the retrieval of hotel information from the system.
# It verifies that the system correctly returns hotel details including:
# - Basic hotel information (name, city, country)
# - Associated rooms and their details
# - Proper error handling for non-existent hotels

@Hotel @Room

Feature: I want to get the details of a hotel

    # Background sets up the test environment with:
    # - A specific test date
    # - Three hotels with their details
    # - Four rooms across different hotels
    Background:
        Given Date is "2025-05-31 10:00:00"

        And there are the following hotels:
            | Id                                   | Name                  | City         | Country   |
            | 11111111-1111-1111-1111-111111111111 | Pramana Watu Kurung   | Ubud         | Indonesia |
            | 22222222-2222-2222-2222-222222222222 | El Racó de Madremanya | Madremanya   | España    |
            | 33333333-3333-3333-3333-333333333333 | Mas La Casassa        | Sant Gregori | España    |

        And there are the following rooms:
            | Id                                   | HotelId                              | Label    |
            | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | Suite    |
            | 22222222-2222-2222-2222-222222222222 | 11111111-1111-1111-1111-111111111111 | 1        |
            | 33333333-3333-3333-3333-333333333333 | 11111111-1111-1111-1111-111111111111 | 2        |
            | 44444444-4444-4444-4444-444444444444 | 22222222-2222-2222-2222-222222222222 | El Jardí |

    # Scenario: Get Hotel with Multiple Rooms
    # Tests the retrieval of a hotel that has multiple rooms
    # Verifies that the system returns:
    # - Complete hotel information
    # - All associated rooms with their details
    # - Proper room count
    Scenario: I get the details of a hotel with several rooms
        When I send a GET request to "/api/hotels/11111111-1111-1111-1111-111111111111"
        Then the response status code should be 200
        Then the JSON should be equal to:
        """
        {
            "id": "11111111-1111-1111-1111-111111111111",
            "name": "Pramana Watu Kurung",
            "city": "Ubud",
            "country": "Indonesia",
            "numberOfRooms": 3
        }
        """

    # Scenario: Get Hotel with Single Room
    # Tests the retrieval of a hotel that has only one room
    # Verifies that the system correctly returns:
    # - Hotel information
    # - Single room details
    # - Proper room count
    Scenario: I get the details of a hotel with a single room
        When I send a GET request to "/api/hotels/22222222-2222-2222-2222-222222222222"
        Then the response status code should be 200
        Then the JSON should be equal to:
        """
        {
            "id": "22222222-2222-2222-2222-222222222222",
            "name": "El Racó de Madremanya",
            "city": "Madremanya",
            "country": "España",
            "numberOfRooms": 1
        }
        """

    # Scenario: Get Hotel with No Rooms
    # Tests the retrieval of a hotel that has no rooms
    # Verifies that the system correctly returns:
    # - Hotel information
    # - Empty rooms array
    # - Proper handling of hotels without rooms
    Scenario: I get the details of a hotel with no rooms
        When I send a GET request to "/api/hotels/33333333-3333-3333-3333-333333333333"
        Then the response status code should be 200
        Then the JSON should be equal to:
        """
        {
            "id": "33333333-3333-3333-3333-333333333333",
            "name": "Mas La Casassa",
            "city": "Sant Gregori",
            "country": "España",
            "numberOfRooms": 0
        }
        """

    # Scenario: Get Non-existent Hotel
    # Tests the system's response when requesting a hotel that doesn't exist
    # Verifies that the system:
    # - Returns a 404 status code
    # - Provides an appropriate error message
    # - Handles non-existent hotel IDs gracefully
    Scenario: I get the details of a hotel that does not exist
        When I send a GET request to "/api/hotels/44444444-4444-4444-4444-444444444444"
        Then the response status code should be 404
        Then the JSON should be equal to:
        """
        {
            "message": "Hotel with id 44444444-4444-4444-4444-444444444444 not found"
        }
        """
