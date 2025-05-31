@Hotel @Room

Feature: I want to get the basic information of a hotel

    Background:
        Given there are the following hotels:
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

    Scenario: Get the basic information of a hotel with several rooms
        When I send a GET request to "/api/hotels/22312e0e-819a-416b-a9ef-ca78e120de45":
        Then the response status code should be 200
        Then the JSON should be equal to:
        """
        {
            "id": "22312e0e-819a-416b-a9ef-ca78e120de45",
            "name": "Pramana Watu Kurung",
            "city": "Ubud",
            "country": "Indonesia",
            "numberOfRooms": 3
        }
        """

    Scenario: Get the basic information of a hotel with one room only
        When I send a GET request to "/api/hotels/49449fbe-025b-4c3a-a9b0-24c11b4bb6eb":
        Then the response status code should be 200
        Then the JSON should be equal to:
        """
        {
            "id": "49449fbe-025b-4c3a-a9b0-24c11b4bb6eb",
            "name": "El Racó de Madremanya",
            "city": "Madremanya",
            "country": "España",
            "numberOfRooms": 1
        }
        """

    Scenario: Get the basic information of a hotel with no rooms
        When I send a GET request to "/api/hotels/c01c8145-6369-40a6-a568-cf6c374a5735":
        Then the response status code should be 200
        Then the JSON should be equal to:
        """
        {
            "id": "c01c8145-6369-40a6-a568-cf6c374a5735",
            "name": "Mas La Casassa",
            "city": "Sant Gregori",
            "country": "España",
            "numberOfRooms": 0
        }
        """

    Scenario: Get the basic information of a hotel that does not exist
        When I send a GET request to "/api/hotels/dec36a1e-e3d9-4d26-ae00-97729f91d623":
        Then the response status code should be 404
        Then the JSON should be equal to:
        """
        {
            "message": "Hotel with id dec36a1e-e3d9-4d26-ae00-97729f91d623 not found"
        }
        """
