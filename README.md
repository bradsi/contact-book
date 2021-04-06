# 📑 Contact Book
A simple web app to manage contacts.

PHP MVC web app (no framework) built for learning purposes. Currently under development.

- MVC architecture
- CRUD operations
- Authentication

**Live demo:** *TBU*  
**Demo email:** demo@example.com  
**Demo password:** test123  

*Screenshot/GIF TBU*

## ⚙ Libraries Used
- Plates (views)
- Monolog (logging)
- PHPUnit (unit testing)

## 🛠 TODO
- Update design
- Add form validation
- Improve error handling
- Refactor duplicate code
- Split `DbConnectionManager` into three for separation of concerns:
    - `DbConnectionManager` - db connection
    - `UserManager` - authentication
    - `ContactManager` - CRUD operations
- Refactor `Helpers` controllers to be used across `AuthController` and `ContactController`    
- Add unit tests
- Cleanup / remove logging