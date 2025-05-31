@User @Hotel @Room @Booking

Feature: I want to make a reservation of a room

    Background:
        Given Date is "2025-05-31 10:00:00"

        And there are the following users:
            | Id                                   | Name          | Email                  |
            | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | Nagini        | nagini@gmail.com       |

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

    Scenario: Make the reservation of a single room
        When I send a POST request to "/api/booking" with body:
        """
        {
            "bookings": [
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
                  "roomId": "842b8630-05e3-4776-949d-5781790c35ed",
                  "checkInDate": "2025-09-04",
                  "checkOutDate": "2025-09-05"
                }
              ]
        }
        """
        Then the response status code should be 201
        Then there should exist the following bookings:
            | UserId                               | RoomId                               | HotelId                              | CheckIn    | CheckOut   |
            | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 842b8630-05e3-4776-949d-5781790c35ed | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2025-09-04 | 2025-09-05 |

    Scenario: Make the following reservations:
                - Room Suite of Pramana Watu Kurung hotel:
                        - between 01-03/10/2023
                        - between 08-10/10/2025
                - Room 1 of Pramana Watu Kurung hotel:
                        - between 01-03/10/2023
                - Room El Jardí of El Racó de Madremanya hotel:
                        - between 01-03/10/2023

        When I send a POST request to "/api/booking" with body:
        """
        {
            "bookings": [
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
                  "roomId": "842b8630-05e3-4776-949d-5781790c35ed",
                  "checkInDate": "2025-10-01",
                  "checkOutDate": "2025-10-03"
                },
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
                  "roomId": "842b8630-05e3-4776-949d-5781790c35ed",
                  "checkInDate": "2025-10-08",
                  "checkOutDate": "2025-10-10"
                },
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
                  "roomId": "701039c2-c38c-41d5-bbb2-70f149606553",
                  "checkInDate": "2025-10-01",
                  "checkOutDate": "2025-10-03"
                },
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
                  "roomId": "5c6f080d-db29-496f-9b0f-2c2cb00f0bab",
                  "checkInDate": "2025-10-11",
                  "checkOutDate": "2025-10-13"
                }
              ]
        }
        """
        Then the response status code should be 201
        Then there should exist the following bookings:
            | UserId                               | RoomId                               | HotelId                              | CheckIn    | CheckOut   |
            | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 842b8630-05e3-4776-949d-5781790c35ed | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2025-10-01 | 2025-10-03 |
            | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 842b8630-05e3-4776-949d-5781790c35ed | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2025-10-08 | 2025-10-10 |
            | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 701039c2-c38c-41d5-bbb2-70f149606553 | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2025-10-01 | 2025-10-03 |
            | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 5c6f080d-db29-496f-9b0f-2c2cb00f0bab | 49449fbe-025b-4c3a-a9b0-24c11b4bb6eb | 2025-10-11 | 2025-10-13 |
