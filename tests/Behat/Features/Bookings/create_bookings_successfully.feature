# Feature: Create Bookings Successfully
# This feature tests the successful creation of room bookings in the system.
# It verifies that users can make single and multiple room reservations
# with valid dates and room availability.

@User @Hotel @Room @Booking

Feature: I want to make a reservation of a room

    # Background sets up the test environment with:
    # - A specific test date
    # - A test user (Nagini)
    # - Three hotels with their details
    # - Four rooms across different hotels
    Background:
        Given Date is "2025-05-31 10:00:00"

        And there are the following users:
            | Id                                   | Name          | Email                  |
            | 11111111-1111-1111-1111-111111111111 | Nagini        | nagini@gmail.com       |

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

    # Scenario: Single Room Reservation
    # Tests the basic functionality of creating a single room booking
    # Verifies that a user can successfully book a room for specific dates
    # and the booking is properly stored in the system
    Scenario: Make the reservation of a single room
        When I send a POST request to "/api/bookings" with body:
        """
        {
            "bookings": [
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "11111111-1111-1111-1111-111111111111",
                  "checkInDate": "2025-09-04",
                  "checkOutDate": "2025-09-05"
                }
              ]
        }
        """
        Then the response status code should be 201
        Then there should exist the following bookings:
            | UserId                               | RoomId                               | HotelId                              | CheckIn    | CheckOut   |
            | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 2025-09-04 | 2025-09-05 |

    # Scenario: Multiple Room Reservations
    # Tests the creation of multiple bookings in a single request
    # Verifies that a user can book:
    # - The same room for different date ranges
    # - Different rooms in the same hotel
    # - Rooms in different hotels
    # All bookings should be created successfully in a single transaction
    Scenario: Make the several reservations
        When I send a POST request to "/api/bookings" with body:
        """
        {
            "bookings": [
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "11111111-1111-1111-1111-111111111111",
                  "checkInDate": "2025-10-01",
                  "checkOutDate": "2025-10-03"
                },
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "11111111-1111-1111-1111-111111111111",
                  "checkInDate": "2025-10-08",
                  "checkOutDate": "2025-10-10"
                },
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "22222222-2222-2222-2222-222222222222",
                  "checkInDate": "2025-10-01",
                  "checkOutDate": "2025-10-03"
                },
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "44444444-4444-4444-4444-444444444444",
                  "checkInDate": "2025-10-11",
                  "checkOutDate": "2025-10-13"
                }
              ]
        }
        """
        Then the response status code should be 201
        Then there should exist the following bookings:
            | UserId                               | RoomId                               | HotelId                              | CheckIn    | CheckOut   |
            | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 2025-10-01 | 2025-10-03 |
            | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 2025-10-08 | 2025-10-10 |
            | 11111111-1111-1111-1111-111111111111 | 22222222-2222-2222-2222-222222222222 | 11111111-1111-1111-1111-111111111111 | 2025-10-01 | 2025-10-03 |
            | 11111111-1111-1111-1111-111111111111 | 44444444-4444-4444-4444-444444444444 | 22222222-2222-2222-2222-222222222222 | 2025-10-11 | 2025-10-13 |
