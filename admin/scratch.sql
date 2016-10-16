-- Users/Awards by Region → US Map chart
-- Users by Date → Bar chart
-- Awards by User/by Date → Bar chart
-- Users/Awards by Time → Line graph


SELECT person.person_id, COUNT(appointment.person_id) AS "number_of_appointments" 
FROM person 
LEFT JOIN appointment ON person.person_id = appointment.person_id 
GROUP BY person.person_id;

SELECT AU.first_name, AU.last_name, AU.email, AU.state, AU.id, AU.created, ACT.title, COUNT(A.class_id) AS 'totalAwards' 
FROM award_user AU 
LEFT JOIN award A ON A.user_id = AU.id 
INNER JOIN act_type ACT ON ACT.id = AU.act_id 
GROUP BY AU.last_name ORDER BY AU.id;

SELECT AU.first_name, AU.last_name, AU.email, AU.state, AU.id, AU.created, COUNT(A.class_id) AS 'totalAwards' 
FROM award_user AU 
LEFT JOIN award A ON A.user_id = AU.id
GROUP BY AU.last_name ORDER BY AU.id;

-- returns correct award numbers for all users
SELECT AU.first_name, AU.last_name, AU.email, AU.state, AU.id, AU.created, COUNT(A.class_id) AS 'totalAwards' 
FROM award_user AU 
LEFT JOIN award A ON A.user_id = AU.id
GROUP BY AU.email 
ORDER BY AU.id

-- returns correct awards numbers AS WELL AS account type (user/admin)
SELECT AU.first_name, AU.last_name, AU.email, AU.state, AU.id, AU.created, ACT.title, COUNT(A.class_id) AS 'totalAwards' 
FROM award_user AU 
LEFT JOIN award A ON A.user_id = AU.id
INNER JOIN act_type ACT ON ACT.id = AU.act_id 
GROUP BY AU.email 
ORDER BY AU.id




-- how many of type x award given by state
SELECT AU.state, CL.title, COUNT(CL.id) AS 'AwardCount' FROM award_user AU
INNER JOIN award A ON A.user_id = AU.id
INNER JOIN class CL ON CL.id = A.class_id
WHERE CL.title = 'Employee of the Week'
GROUP BY AU.state;


SELECT * from award A
INNER JOIN class CL ON CL.id = A.class_id;
