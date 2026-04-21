Healthcare Management System – Project Description

The Healthcare Management System is a web-based application developed to simplify and organize the day-to-day operations of a hospital or clinic. 
The system provides a centralized platform where patients, doctors, and administrators can interact efficiently. It replaces manual processes with a digital solution, 
making tasks like appointment booking, patient record management, and scheduling more accurate and convenient.

The primary objective of this system is to improve the overall efficiency of healthcare services. It allows patients to book appointments easily, helps doctors manage their schedules and patient records, and enables administrators to monitor and control the system effectively. 
By automating these processes, the system reduces errors, saves time, and improves service quality.

The system supports three types of users: patients, doctors, and administrators. Each role has its own set of functionalities. Patients can register, log in, book appointments with doctors based on specialization and availability, view their appointments, 
check their queue status, and access their medical history. Doctors can view their scheduled appointments, manage the patient queue, 
update appointment statuses such as pending, ongoing, or completed, and record medical details including diagnosis, prescribed medicines, and recommended tests. Administrators have full control over the system. They can view all appointments, manage doctor schedules, 
search doctors by specialization, analyze reports, and identify top-performing or most experienced doctors.

The system is built using HTML, CSS, and Bootstrap for the frontend, PHP for the backend, and MySQL as the database. It follows a client-server architecture, where users interact through a web interface and all data is stored and managed in a structured relational database.

The database design is one of the core strengths of the project. It uses multiple related tables such as patient, doctor, appointment, branch, timeslot, doctor_schedule, queue, and medical_history. The appointment table acts as the central link connecting patients, doctors, 
branches, and time slots. Relationships between tables are maintained using foreign keys, ensuring consistency and integrity of data.

One of the key features of the system is the appointment booking process. The system ensures that patients cannot book duplicate appointments, that time slots are not overfilled, and that doctors are only booked on their available days and branches. 
Another important feature is the queue management system. Each appointment is assigned a token number, and patients are categorized as 
waiting, currently being served, or completed. This simulates a real-world hospital environment and helps manage patient flow effectively.

The system also includes a medical history module where doctors can store detailed treatment records for each patient. Patients can later access their history, which makes follow-up treatments easier and more organized.

In addition, the system provides reporting features for administrators. These include generating summaries such as the number of appointments per branch and identifying the most experienced doctors. These insights help in decision-making and resource management.

From a database perspective, the project demonstrates the use of important SQL concepts such as joins to combine data from multiple tables, group by for generating reports, aggregate functions like count for managing queues and slot limits, and subqueries for advanced data retrieval. 
Prepared statements are used in many parts of the system to improve security and prevent SQL injection.

Overall, this project demonstrates how a real-world healthcare system can be effectively managed using web technologies and a relational database. It improves organization, enhances user experience, and provides a scalable solution for managing hospital operations.
