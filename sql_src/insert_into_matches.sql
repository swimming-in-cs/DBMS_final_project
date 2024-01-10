INSERT matches SELECT tourney_id, match_num, winner_id,	winner_seed, winner_entry, score, best_of,
	                  round, minutes, w_ace, w_df, w_svpt, w_1stIn,	w_1stWon, w_2ndWon,	w_SvGms, w_bpSaved,
                      w_bpFaced, loser_id, loser_seed, loser_entry,	l_ace, l_df, l_svpt, l_1stIn, l_1stWon,
                      l_2ndWon, l_SvGms, l_bpSaved,	l_bpFaced FROM atp;
