# Feature: Create Bookings With Exceptions
# This feature tests the error handling when creating room bookings.
# It verifies that the system properly handles invalid booking attempts
# and provides appropriate error messages for different failure scenarios.

@User @Hotel @Room @Booking

Feature: I want to make a reservation of a room

    # Background sets up the test environment with:
    # - A specific test date
    # - A test user (Nagini)
    # - Three hotels with their details
    # - Four rooms across different hotels
    # - One existing booking to test conflicts
    Background:
        Given Date is "2025-05-31 10:00:00"

        And there are the following users:
            | Id                                   | Name   | Email            |
            | 11111111-1111-1111-1111-111111111111 | Nagini | nagini@gmail.com |

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

        And there are the following bookings:
            | Id                                   | UserId                               | RoomId                               | HotelId                              | CheckIn    | CheckOut   |
            | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 2025-10-01 | 2025-10-03 |

    # Scenario: Non-existent Room
    # Tests the system's response when attempting to book a room that doesn't exist
    # Verifies that the system returns a 404 error and doesn't create any bookings
    Scenario: I try to make the reservation of a single room, but the room does not exist
        When I send a POST request to "/api/bookings" with body:
        """
        {
            "bookings": [
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "21e27a5f-f007-458d-9d81-936fe672e80f",
                  "checkInDate": "2025-09-04",
                  "checkOutDate": "2025-09-05"
                }
              ]
        }
        """
        Then the response status code should be 404
        And there should not exist the following bookings:
            | UserId                               | RoomId                               | CheckIn    | CheckOut   |
            | 11111111-1111-1111-1111-111111111111 | 21e27a5f-f007-458d-9d81-936fe672e80f | 2025-09-04 | 2025-09-05 |

    # Scenario: Multiple Booking Errors
    # Tests the system's handling of multiple invalid booking attempts in a single request
    # Verifies that the system:
    # - Detects room already booked
    # - Detects dates in the past
    # - Returns appropriate error messages for each issue
    # - Doesn't create any bookings when there are errors
    Scenario: I try to make the reservation of several rooms, but there are the following problems:
                - The room Suite of Pramana Watu Kurung Hotel is already booked
                - The reservation of the room 1 of Pramana Watu Kurung Hotel is not correct since dates are in the past
        When I send a POST request to "/api/bookings" with body:
        """
        {
            "bookings": [
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "11111111-1111-1111-1111-111111111111",
                  "checkInDate": "2025-10-02",
                  "checkOutDate": "2025-10-07"
                },
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "22222222-2222-2222-2222-222222222222",
                  "checkInDate": "2025-04-04",
                  "checkOutDate": "2025-04-05"
                }
              ]
        }
        """
        Then the response status code should be 400
        Then the JSON should be equal to:
        """
            {
                "success": false,
                "bookingIdList": [],
                "errorList": [
                    {
                        "message": "Room with id 11111111-1111-1111-1111-111111111111 is already booked between 2025-10-02 and 2025-10-07"
                    },
                    {
                        "message": "Check-in date 2025-04-04 of room with id 22222222-2222-2222-2222-222222222222 is in the past"
                    }
                ]
            }
        """
        And there should not exist the following bookings:
            | UserId                               | RoomId                               | CheckIn    | CheckOut   |
            | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 2025-10-02 | 2025-10-07 |
            | 11111111-1111-1111-1111-111111111111 | 22222222-2222-2222-2222-222222222222 | 2025-04-04 | 2025-04-05 |

    # Scenario: Partial Booking Failure
    # Tests the system's handling of a request where some bookings are valid
    # but others are invalid. Verifies that:
    # - The system doesn't create any bookings if any are invalid
    # - Returns appropriate error messages
    # - Maintains data consistency by not partially creating bookings
    Scenario: I try to make the reservation of two rooms, and the first reservation is ok, but the second is not. None of them should be saved
        When I send a POST request to "/api/bookings" with body:
        """
        {
            "bookings": [
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "11111111-1111-1111-1111-111111111111",
                  "checkInDate": "2025-11-02",
                  "checkOutDate": "2025-11-07"
                },
                {
                  "userId": "11111111-1111-1111-1111-111111111111",
                  "roomId": "22222222-2222-2222-2222-222222222222",
                  "checkInDate": "2025-04-04",
                  "checkOutDate": "2025-04-05"
                }
              ]
        }
        """
        Then the response status code should be 400
        Then the JSON should be equal to:
        """
            {
                "success": false,
                "bookingIdList": [],
                "errorList": [
                    {
                        "message": "Check-in date 2025-04-04 of room with id 22222222-2222-2222-2222-222222222222 is in the past"
                    }
                ]
            }
        """
        And there should not exist the following bookings:
            | UserId                               | RoomId                               | CheckIn    | CheckOut   |
            | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 2025-11-02 | 2025-11-07 |
            | 11111111-1111-1111-1111-111111111111 | 22222222-2222-2222-2222-222222222222 | 2025-04-04 | 2025-04-05 |

