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
