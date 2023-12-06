// Module Table 
1.name

//Module Management
1.Module_id  // foreign key Module Table 
2.Version
3.HRMS Minimum version //foreign key Base Version
4.Released Date
5.Change Log

//Add new customer customer table	
1.Name
2.Company name
3.Version
4.Email address

//Purchased Modules
1.customer_id //foreign key
2.Module_Management_id //foreign key Module Management
3.Version //foreign 
4.Date of purchased 
5.License //text unique

//Payment History
1.customer_id //foreign key
2.Module_Management_id //foreign key Module Management
3.Payment ID
4.Payment Date
5.Amount
6.Provider
7.Method //enum

//Base Version 
1.Base Version
2.Update Date
3.Change Log


