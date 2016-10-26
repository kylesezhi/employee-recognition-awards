-- what users and admins are from a state
SELECT first_name, last_name from award_user WHERE state = "HI";

-- what users are from a state
SELECT AU.first_name, AU.last_name from award_user AU 
INNER JOIN act_type ACT ON ACT.id = AU.act_id 
WHERE ACT.title = 'regular';

-- how many of type x award given by state
SELECT AU.state, COUNT(CL.id) AS 'AwardCount' FROM award_user AU
INNER JOIN award A ON A.user_id = AU.id
INNER JOIN class CL ON CL.id = A.class_id
WHERE CL.title = 'Employee of the Week'
GROUP BY AU.state;

-- how many of all awards by state
SELECT AU.state, COUNT(CL.id) AS 'AwardCount' FROM award_user AU
INNER JOIN award A ON A.user_id = AU.id
INNER JOIN class CL ON CL.id = A.class_id
GROUP BY AU.state;

<<<<<<< HEAD
-- how many awards give by specific user
SELECT A.first_name, A.last_name, A.id, CL.title FROM award A
=======
-- how many awards given by specific user
SELECT A.first_name, A.last_name, CL.title FROM award A
>>>>>>> 53c217996c38fd6d787d03b0d991dd10aa5cf62c
INNER JOIN class CL on CL.id = A.class_id
WHERE A.user_id = 53;

-- how many total awards
SELECT COUNT(class_id) AS 'totalAwards' from award; 

-- how many awards by type
SELECT CL.title, COUNT(A.class_id) AS 'countPer' from class CL 
INNER JOIN award A ON A.class_id = CL.id
GROUP BY CL.title;

-- how many awards has each user given
SELECT AU.first_name, AU.last_name, COUNT(A.class_id) AS 'totalAWards' FROM award_user AU
INNER JOIN award A ON A.user_id = AU.id
GROUP BY AU.last_name;

-- how many of type award has each user given
SELECT AU.first_name, AU.last_name, COUNT(CL.id) AS 'totalAwards' FROM award_user AU
INNER JOIN award A ON A.user_id = AU.id
INNER JOIN class CL ON CL.id = A.class_id
WHERE CL.title = 'Employee of the Week'
GROUP BY AU.last_name;

-- how many awards give during a specific time period by state
SELECT AU.state, COUNT(A.class_id) as 'totalAwards' FROM award_user AU
INNER JOIN award A ON A.user_id = AU.id
WHERE A.award_date BETWEEN '2016-10-01' AND '2017-01-31'
GROUP BY AU.state;

-- how many of awards given by a user in a specific time period
SELECT AU.first_name, AU.last_name,  COUNT(A.class_id) as 'totalAwards' FROM award_user AU
INNER JOIN award A ON A.user_id = AU.id
WHERE A.award_date BETWEEN '2016-10-01' AND '2017-01-31'
GROUP BY AU.last_name;

-- how many of a specific award given during a time period by state

-- how many of each award given by a user in a specific time period

-- how many total awards in the last 30 days

-- how many specific awards in the last 30 days

-- how many total awards in the last 30 days by state

-- how many total awards in the last 30 days by user

-- how many specific awards by state in the last 30 days

-- how many specific awards by user in the last 30 days