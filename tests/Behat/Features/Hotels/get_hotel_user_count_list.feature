@User @Hotel @Room

Feature: I want to know how many unique users has booked rooms per hotel

    Background:
        Given there are the following users:
            | Id                                   | Name          | Email                  |
            | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | Nagini        | nagini@gmail.com       |
            | 52e7e83e-e683-4c41-93e9-cd45ab05076b | Tom Riddle    | tomriddle@gmail.com    |
            | fb727e35-d2d9-4f27-b115-5ef317acd4de | Severus Snape | severussnape@gmail.com |

        And there are the following hotels:
            | Id                                   | Name                  | City         | Country   |
            | 22312e0e-819a-416b-a9ef-ca78e120de45 | Pramana Watu Kurung   | Ubud         | Indonesia |
            | 49449fbe-025b-4c3a-a9b0-24c11b4bb6eb | El Racó de Madremanya | Madremanya   | España    |
            | c01c8145-6369-40a6-a568-cf6c374a5735 | Mas La Casassa        | Sant Gregori | España    |

        And there are the following rooms:
            | Id                                   | HotelId                              | Label    |
            | 842b8630-05e3-4776-949d-5781790c35ed | 22312e0e-819a-416b-a9ef-ca78e120de45 | Suite    |
            | 701039c2-c38c-41d5-bbb2-70f149606553 | 22312e0e-819a-416b-a9ef-ca78e120de45 | 1        |
            | 5bfafa9b-ee92-4b1d-93b1-691167b74b00 | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2        |
            | 5c6f080d-db29-496f-9b0f-2c2cb00f0bab | 49449fbe-025b-4c3a-a9b0-24c11b4bb6eb | El Jardí |

        And there are the following bookings:
            | Id                                   | UserId                               | RoomId                               | HotelId                              | CheckIn    | CheckOut   |
            | 9c9e196f-9750-4a10-833f-f0d446680c2d | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 842b8630-05e3-4776-949d-5781790c35ed | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2025-07-24 | 2025-07-26 |
            | 2e4d2b74-d85b-4f39-b358-afe54f893b7c | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 842b8630-05e3-4776-949d-5781790c35ed | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2025-09-01 | 2025-09-16 |
            | 0899c55f-ce6d-4d4d-9d32-a158eb605787 | 52e7e83e-e683-4c41-93e9-cd45ab05076b | 701039c2-c38c-41d5-bbb2-70f149606553 | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2025-06-01 | 2025-01-05 |
            | e0b1559c-4c7a-4d64-8ff9-2e02544da502 | 52e7e83e-e683-4c41-93e9-cd45ab05076b | 5bfafa9b-ee92-4b1d-93b1-691167b74b00 | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2025-07-01 | 2025-07-05 |
            | 86ef3c89-4cb1-4c11-99b5-73398f9c8d87 | 52e7e83e-e683-4c41-93e9-cd45ab05076b | 5c6f080d-db29-496f-9b0f-2c2cb00f0bab | 49449fbe-025b-4c3a-a9b0-24c11b4bb6eb | 2025-08-01 | 2025-08-05 |

    Scenario: Get the count of unique users per hotel with:
                - one user (Nagini) that booked twice the Suite in Pramana Watu Kurung
                - one user (Tom Riddle) that booked:
                    - Rooms 1 and 2 in Pramana Watu Kurung once
                    - Room El Jardí in El Racó de Madremanya once
        When I send a GET request to "/api/hotels/user-count-list":
        Then the response status code should be 200
        Then the JSON should be equal to:
        """
        {
            "data": [
                {
                    "id": "22312e0e-819a-416b-a9ef-ca78e120de45",
                    "users": 2
                },
                {
                    "id": "49449fbe-025b-4c3a-a9b0-24c11b4bb6eb",
                    "users": 1
                },
                {
                    "id": "c01c8145-6369-40a6-a568-cf6c374a5735",
                    "users": 0
                }
            ]
        }
        """
