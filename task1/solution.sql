SELECT
    u.name,
    COUNT(pn.phone) AS phones

FROM users AS u

/* "число указанных телефонных номеров", поэтому INNER, чтобы не показывать людей с нулём телефонов */
INNER JOIN phone_numbers AS pn ON pn.user_id = u.id

WHERE
  u.gender = 2
  AND TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(u.birth_date), CURDATE()) BETWEEN 18 AND 22

GROUP BY u.id;
