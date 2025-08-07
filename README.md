
# Task 3 - User Pose Management System

## Description
A simple web project for managing user pose registration and display using PHP and MySQL.  
Allows users to add new poses, view the list of poses, update the status of each pose, and delete poses.

## Requirements
- A server supporting PHP (like XAMPP, WAMP, or a real hosting)
- MySQL database
- Modern web browser

## How to Run Locally
1. Import the `poses.sql` file into your MySQL database to create the necessary tables and initial data.  
2. Update the database connection details in `db.php` to match your database settings (host, username, password, and database name).  
3. Upload the project files to your local web server folder (e.g., `htdocs` in XAMPP).  
4. Open your browser and go to `http://localhost/<folder_name>/index.php`.

## File Explanation
- `index.php`: The main page displaying the form and the list of poses.  
- `db.php`: Database connection file.  
- `get_run_pose.php`: Fetches pose data from the database.  
- `save_pose.php`: Saves a new pose to the database.  
- `remove_pose.php`: Deletes a specific pose.  
- `update_status.php`: Updates the status of a specific pose.  
- `poses.sql`: Database file containing tables and initial data.

## Notes
- The project requires PHP and MySQL, so it cannot be run directly on GitHub Pages.  
- The project should be hosted on a server that supports PHP and MySQL to run properly.

---

If you want help uploading it to a free hosting later, or need explanation on any part, I’m here to help!
