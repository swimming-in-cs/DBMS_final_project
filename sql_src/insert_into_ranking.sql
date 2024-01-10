INSERT ignore INTO ranking 
SELECT DISTINCT substring(tourney_date, 1, 4), winner_rank, winner_id, winner_name
FROM atp
GROUP BY winner_id
ORDER BY winner_rank;

INSERT ignore INTO ranking 
SELECT DISTINCT substring(tourney_date, 1, 4), loser_rank, loser_id, loser_name
FROM atp
GROUP BY loser_id
ORDER BY loser_rank;