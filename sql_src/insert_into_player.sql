INSERT ignore INTO player 
SELECT DISTINCT winner_id, winner_name, winner_hand, winner_ht, winner_ioc, winner_age 
FROM atp;
INSERT ignore INTO player 
SELECT DISTINCT loser_id, loser_name, loser_hand, loser_ht, loser_ioc, loser_age 
FROM atp;
