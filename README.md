# LibraryWebsite
The aim of this assignment was to develop a book reservation web site using PHP and MySQL database. The application allows users to search for and reserve library books. Specifically, the application enables the following:
- Login:
 * The user must identify themselves to the system in order to use the system and throughout the whole site. If they have not previously used the system, they must register their details.
- Registration:
 * This allows a user to enter their details on the system. The registration process validates that all details are entered.
- Search for a book:
 The system allows the user to search in a number of ways: 
 * by any one or any two or all three of the categories; title, author and category (allowing for partial search on all three)
 * book category description is a dropdown menu (book category is retrieved from database)
 * title and author are text inputs
- The results of the search displays as a list from which the user can then reserve a book if available. If the book is already reserved, the user is not allowed to reserve the book.
- Reserve a book:
 * The system allows a user to reserve a book provided that no-one else has reserved the book yet. The reservation functionality captures the date on which the reservation was made.
- View reserved books:
 * the system allows the user to see a list of the book(s) currently reserved by that user. User is able to remove the reservation also.
