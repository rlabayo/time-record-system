# About the Project

## Daily Time Record System

To build a system that will use to record the time in and time out of the employees for their daily attendance.


## Languages/Tools:
* PHP, CodeIgniter Framework, MySql, REST API, JavaScript, AJAX, jQuery, HTML, CSS, Bootstrap
* Chrome Dev tools, Visual Studio Code, Apache


## Modules

* Employee Records
	- Employee Records is only visible to a Super Admin user and the one who is able to add, update and delete of employee records.
	 
	![Employee page](/Employee-module.png "Employee Page")
* Employee Time Records
	- If the user is not a Super Admin, they can only access Time Recording and Time Record page.
	- Employee time records will display all the time records of the specific user. 
	
	![Employee time record page](/Employee-time-record.png "Employee Time Record Page")
	
	- If the user is a Super admin, they will be able to view all the employees time records.
	
	![Employee time record page for super admin](/Time-record-super-admin.png "Employee Time Record Page for Super Admin")
	
* Time Recording
	- The employees will be able to time in and time out in time recording page using their Employee ID.
	
	![Alt text](/Time-recording.png "Time Recording Page")
	
	- This page will also display the time in and time out of all the employees on that day. 
	
* User 
 	- User module is only visible to a Super Admin user.
 	- The user will be able to add, update, delete user records.
	- The user can't delete their own account
		
		![Alt text](/User-module.png "User Page")
	
		- Add user modal 
		
		![Alt text](/add-user.png "Add user modal")
	
		- Edit user modal
		
		![Alt text](/edit-user.png "Edit user modal")
	
		- Delete confirmation modal 
		
		![Alt text](/delete-confirm.png "Delete confirmation modal")
 
* Log In / Log Out
	- Once the user login, the session will start and will expire after 10mins.
	- If there still a session, the page will be redirected to the time recording page when the user visit the log in page.


Note: This is a sample time recording web application using CodeIgniter and other web technologies. The application is not finish yet and needs some more improvement.


Check on this [demo link](https://github.com/rlabayo/time-record-system/blob/main/Time-recording.mov) for a sample video presentation.



