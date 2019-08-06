# Implementations
This project was implemented via the agile method of development using the following technologies;

**Front-End Web Technologies:** The front-end technologies implemented in the project are HTML, CSS and JavaScript (EcmaScript 6). AJAX (Asynchronous XML and JavaScript) is an inclusive technology and has served in User Experience (UX) by loading pages from the server actively via the XMLHttpRequests. It is cross-browser compatible because the ActiveXObject was used for IE8 and below and the XMLHttpRequest for Opera, Edge, Safari etc, hence enhancing speed. The loading time, hence is enhanced and users do not need to load pages most times for contents to be parsed to their display.

**Back-end Web Technologies:** The back-end technologies used in this project are SQL and PHP (OOP), including the MySQL RDBMS (Relative Database Management System) as a data storage means. The PHP extension used for connection to the MySQL service is the mysqli extension. Prepared statements are not used.
# Graphical Features
Pagination: The pagination feature is inclusive in the project which enhances UX as users can easily navigate to any index of enumeration of the products. It is only visible at default.

**Searching/Filtering:** The system allows users to search for products by name or by selecting from the available filters like Regions, Seasons, and Nature. There are also sub-filters provided in the various filters.
User Logging (Session Handling): The project allows users to register and create accounts, also providing them with a Dashboard with stats (Completed orders and pending orders).

**Four-Paged Application**: This application is a four-page application, in the sense that there are only four pages in use. The index page handles most of the processes like viewing of products (Both logged in and out), checkout and cart access.
# Front-end Scripting Features

**Minified Functions:** There are some functions and scripts that are minified in programming. For instance, the document.getElementById(‘elementid’); is minified to a term _(‘elementid’) which therefore fastens the process of code-writing. Also, the popup for messages was attributed to a specific element and a function err() with the message parameter, such that when one calls the function with a text as a parameter, the pop up DOM element (DIV) shows up with the message. E.g. err(“Invalid Expression”) displays that as an error message.

**Function specific Scripts:** The scripts in the project are defined for specific pages. For instance, the cart.js file handles the scripts for cart process (addition, removal from cart etc.) and the product.js file handles the checkout details.
Simplified Scripts: The scripts are written in the shortest way possible (in my view). This entails that they are brief, reusable and concise.
# Back-end Scripting Features

**Programming Method:** The method of programming used in the back-end is OOP (Object-Oriented Programming) with PHP. This therefore makes the code reusable, simpler and comprehensive.
Security Methods: The site has been secured against XSS, SQL injection, Script embedding and has been made to validate user input by use of Regular Expressions for the form fields.

**Database Usage:** It makes use of a Relational Database Management System (RDBMS) MySQL via SQL. There is CRUD (Creation, Retrieval, Update and Deletion) query usage.
# Overall Features

Speed

Performance

Reusable Code

High UX

Quick access

Little or no IT Expert involvement

# Payment Gateway
The project uses the PayStack payment gateway via a JavaScript API (inline.js). This works by parsing the price to the gateway and performing an arithmetical operation amount * 100 from Nigerian Naira (NGN) to Kobo (K). After payment, the transaction reference is parsed to the server with the amount and the data is stored accordingly. The available currency is NGN.
# Data Processing
The client data is stored for future use. The clients are granted the access to update the shipping details per product(s) ordered on their dashboards. They are given an overview in form of Completed Orders and Pending Orders.
# Intriguing Feature
The index page is a single page but shows two views (Logged in and logged out). When logged in, the Buy Now and Add to Cart buttons are visible, including the Cart. But the reverse is the case when logged out.
# Conclusion
The web application has been made with latest scripting features (Ajax) and UI and is quite similar to the sample given for development/reference. The reason why the product may not be very effective is because of low-engagement and meshing with academic activities. Please pardon any unnoticed bug(s).
