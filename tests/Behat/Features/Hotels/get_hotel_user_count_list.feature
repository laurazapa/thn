# Feature: Get Hotel User Count List
# This feature tests the retrieval of hotel popularity metrics by counting
# the number of unique users who have booked rooms in each hotel.
# It verifies that the system correctly:
# - Counts unique users per hotel
# - Handles hotels with multiple bookings by the same user
# - Includes hotels with no bookings
# - Returns proper hotel details with user counts

@User @Hotel @Room @Booking

Feature: I want to see the number of users who have booked rooms in each hotel

    # Background sets up the test environment with:
    # - A specific test date
    # - Three test users (Nagini, Tom Riddle, Voldemort)
    # - Three hotels with their details
    # - Four rooms across different hotels
    # - Multiple bookings to test different scenarios:
    #   * Hotel One: 2 unique users (Nagini and Tom Riddle)
    #   * Hotel Two: 1 unique user (Nagini)
    #   * Hotel Three: No bookings
    Background:
        Given there are the following users:
            | Id                                   | Name          | Email                  |
            | 11111111-1111-1111-1111-111111111111 | Nagini        | nagini@gmail.com       |
            | 22222222-2222-2222-2222-222222222222 | Tom Riddle    | tomriddle@gmail.com    |
            | 33333333-3333-3333-3333-333333333333 | Severus Snape | severussnape@gmail.com |

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
            | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 2025-07-24 | 2025-07-26 |
            | 22222222-2222-2222-2222-222222222222 | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 11111111-1111-1111-1111-111111111111 | 2025-09-01 | 2025-09-16 |
            | 33333333-3333-3333-3333-333333333333 | 22222222-2222-2222-2222-222222222222 | 22222222-2222-2222-2222-222222222222 | 11111111-1111-1111-1111-111111111111 | 2025-06-01 | 2025-01-05 |
            | 44444444-4444-4444-4444-444444444444 | 22222222-2222-2222-2222-222222222222 | 33333333-3333-3333-3333-333333333333 | 11111111-1111-1111-1111-111111111111 | 2025-07-01 | 2025-07-05 |
            | 55555555-5555-5555-5555-555555555555 | 22222222-2222-2222-2222-222222222222 | 44444444-4444-4444-4444-444444444444 | 22222222-2222-2222-2222-222222222222 | 2025-08-01 | 2025-08-05 |

    # Scenario: Get Hotel User Counts
    # Tests the retrieval of user counts for all hotels
    # Verifies that the system correctly:
    # - Counts unique users per hotel (not total bookings)
    # - Includes hotels with no bookings (count = 0)
    # - Returns proper hotel details with user counts
    # - Maintains data consistency across multiple bookings
    Scenario: I get the list of hotels with the number of users who have booked rooms in each hotel
        When I send a GET request to "/api/hotels/user-count-list"
        Then the response status code should be 200
        Then the JSON should be equal to:
        """
        {
            "data": [
                {
                    "id": "11111111-1111-1111-1111-111111111111",
                    "users": 2
                },
                {
                    "id": "22222222-2222-2222-2222-222222222222",
                    "users": 1
                },
                {
                    "id": "33333333-3333-3333-3333-333333333333",
                    "users": 0
                }
            ]
        }
        """
