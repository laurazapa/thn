@User @Hotel @Room @Booking

Feature: I want to make a reservation of a room

  Background:
    Given Date is "2025-05-31 10:00:00"

    And there are the following users:
      | Id                                   | Name   | Email            |
      | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | Nagini | nagini@gmail.com |

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
      | 2d5de0d4-1537-4b84-9ee0-b06bacf5b57c | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 842b8630-05e3-4776-949d-5781790c35ed | 22312e0e-819a-416b-a9ef-ca78e120de45 | 2025-10-01 | 2025-10-03 |


  Scenario: I try to make the reservation of a single room, but the room does not exist
    When I send a POST request to "/api/booking" with body:
        """
        {
            "bookings": [
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
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
      | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 21e27a5f-f007-458d-9d81-936fe672e80f | 2025-09-04 | 2025-09-05 |

  Scenario: I try to make the reservation of several rooms, but there are the following problems:
                - The room Suite of Pramana Watu Kurung Hotel is already booked
                - The reservation of the room 1 of Pramana Watu Kurung Hotel is not correct since dates are in the past
    When I send a POST request to "/api/booking" with body:
        """
        {
            "bookings": [
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
                  "roomId": "842b8630-05e3-4776-949d-5781790c35ed",
                  "checkInDate": "2025-10-02",
                  "checkOutDate": "2025-10-07"
                },
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
                  "roomId": "701039c2-c38c-41d5-bbb2-70f149606553",
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
                    "message": "Room with id 842b8630-05e3-4776-949d-5781790c35ed is already booked between 2025-10-02 and 2025-10-07"
                },
                {
                    "message": "Check-in date 2025-04-04 of room with id 701039c2-c38c-41d5-bbb2-70f149606553 is in the past"
                }
            ]
        }
    """
    And there should not exist the following bookings:
      | UserId                               | RoomId                               | CheckIn    | CheckOut   |
      | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 842b8630-05e3-4776-949d-5781790c35ed | 2025-10-02 | 2025-10-07 |
      | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 701039c2-c38c-41d5-bbb2-70f149606553 | 2025-04-04 | 2025-04-05 |

  Scenario: I try to make the reservation of two rooms, and the first reservation is ok, but the second is not. None of them should be saved
    When I send a POST request to "/api/booking" with body:
        """
        {
            "bookings": [
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
                  "roomId": "842b8630-05e3-4776-949d-5781790c35ed",
                  "checkInDate": "2025-11-02",
                  "checkOutDate": "2025-11-07"
                },
                {
                  "userId": "8d9f3bb0-f90e-4fc2-b564-9530a94b32c8",
                  "roomId": "701039c2-c38c-41d5-bbb2-70f149606553",
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
                    "message": "Check-in date 2025-04-04 of room with id 701039c2-c38c-41d5-bbb2-70f149606553 is in the past"
                }
            ]
        }
    """
    And there should not exist the following bookings:
      | UserId                               | RoomId                               | CheckIn    | CheckOut   |
      | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 842b8630-05e3-4776-949d-5781790c35ed | 2025-11-02 | 2025-11-07 |
      | 8d9f3bb0-f90e-4fc2-b564-9530a94b32c8 | 701039c2-c38c-41d5-bbb2-70f149606553 | 2025-04-04 | 2025-04-05 |

