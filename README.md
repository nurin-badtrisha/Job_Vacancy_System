# Job_Vacancy_System
Web-based job vacancy management system using PHP and MySQL


**User Manual**

This system supports three main user roles: **Admin**, **Person In Charge** and **Applicant**. Below is the detailed functional guide for each user characteristics

**Table of Contents** 
1. Admin Manual 
2. Person In Charge (PIC) manual 
3. Applicant Manual 


**##Admin User Manual**
The Administrator portal provides complete oversight of applicants, partner company records, and system-wide Person In Charge (PIC) account management.

###Core function 
1. **Register Person In Charge:** Create and onboard new PIC accounts into the system.
> Admin can register pic by fill in the requirement form "Register PIC" that appear in top bar header, beside the "Admin Dashboard".

2. **View Application Details:** Access and review comprehensive information for all submitted job applications.
> Admin can view application details in the "Admin Dashboard". The dashboard will show all the applicant application from all the company that admin already register.

3. **Remove And Edit Person In Charge:** Delete or edit details for a specific company.
> 1. Admin can edit or delete company details in the top bar header that show "View PIC Details" in between "Admin Dashboard" and "Register PIC"
> 2. Admin will do the edit or delete by row. Each of the company details (by row) will provide button "Edit" and "Delete"
> 3. For edit section,  Admin must navigate to the table that have "Actions" and click the "Edit" button and he can edit any information that contains in the row which is company name, company email, company phone number and company address.
> 4. For delete section, Admin must navigate in the same table as "Edit" button, there will see the "Delete" button beside that and just click the "Delete" button so all the company details  in that row will be deleted.

4. **Generate Monthly Analytics Reports:** Generate dynamic operational reports filtered by month, complete with graphical data visualization 
> 1. At the bottom of "Admin Dashboard" interface, admin will see button "View Report". Once the admin click the button it will go to the monthly report that will show the bar chart and the rank for the every company that get from the highest job application to the lowest. 
> 2.  The report will show the graphical data which is bar chart to make the analysis much easier.



**## Person In Charge (PIC) manual**
The PIC manages specific operational functions, job requirement details, and application statuses.

###Core Function
1. **Make Job Posting:** Create and publish new job openings to the web application
> 1. PIC can make job posting by click the button "Post Job" in the top bar header of their dashboard. 
> 2. PIC need to fill the all the requirement for make a job posting which is add picture, job position, company name, location, language preferences, educational level, years of working experience, working days, salary range and job description.
> 3. After PIC fill in all the requirement then PIC can click button "POST !" to posting the job and they will going back to PIC dashboard.
> 4. If PIC suddenly decided not to post the job, they can click button "BACK" beside the button "POST" to going back to PIC dashboard.

2. **View and Update Application Status:** Access and read through the details and resume that applicant attach and decided to "Approve" or "Rejected" the applicant.
> 1. PIC can review application details by clicking the button "APPLICANT" at the top bar header of their dashboard.
> 2. 


