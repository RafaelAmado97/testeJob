# Users
- **Description**: This module handles user-related operations such as user creation, authentication, and profile management.
- **Roles**: Defines different user roles and their permissions.
- **Functions**:
    - `create_user(username, password, email)`: Creates a new user with the given username, password, and email.
    - `authenticate_user(username, password)`: Authenticates a user with the provided username and password.
    - `get_user_profile(user_id)`: Retrieves the profile information of the user with the specified user ID.

# Boards
- **Description**: This module manages board-related functionalities including board creation, retrieval, and updates.
- **Functions**:
    - `create_board(name, user_id)`: Creates a new board with the given name for the specified user.
    - `get_board(board_id)`: Retrieves the details of the board with the specified board ID.
    - `update_board(board_id, name)`: Updates the name of the board with the given board ID.

# Filament
- **Description**: This module deals with filament-related operations such as adding new filament types, retrieving filament details, and managing filament inventory.
- **Functions**:
    - `add_filament(type, color, quantity)`: Adds a new filament type with the specified color and quantity.
    - `get_filament(filament_id)`: Retrieves the details of the filament with the given filament ID.
    - `update_filament(filament_id, quantity)`: Updates the quantity of the filament with the specified filament ID.
