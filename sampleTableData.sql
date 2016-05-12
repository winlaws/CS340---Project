INSERT INTO location (streetAddress, city, state, zip) 
VALUES (("123 Somerwhere Rd", "Corvallis", "Oregon", 97330),
	    -- (, "Corvallis", "Oregon", 97333), 
	    -- (, "Corvallis", "Oregon", ),
	    -- (, "Corvallis", "Oregon", ),
	    -- (, "Corvallis", "Oregon", ),
	    ("1550 Brickell Ave", "Miami", "Florida", 33129),
	    ("3555 SW 8th St", "Miami", "Florida", 33135),
	    ("306 NW 27th Ave", "Miami", "Florida", 33125),
	    ("3190 Commodore Plaza", "Miami", "Florida", 33133),
	    ("777 Brickell Ave", "Miami", "Florida", 33131),
	    ("15 SE 10th St", "Miami", "Florida", 33131),
	    ("532 2nd Street", "Houston", "Texas", 77004)
	    -- (, "Houston", "Texas")
	    -- (, "Houston", "Texas")
	    -- (, "Houston", "Texas")
	    -- (, "Houston", "Texas")
	    );

INSERT INTO user (username, password, lid) 
VALUES (("swinlaw", "password1", (SELECT id FROM location WHERE streetAddress="123 Somerwhere Rd" AND city="Corvallis" AND state="Oregon" AND zip=97330)),
		("fernandezd6", "12345678", (SELECT id FROM location WHERE streetAddress="1550 Brickell Ave" AND city="Miami" AND state="Florida" AND zip=33129)),
		("texas_pete", "secret123", (SELECT id FROM location WHERE streetAddress="532 2nd Street" AND city="Houston" AND state="Texas" AND zip=77004)));

INSERT INTO tag (description) 
VALUES ("Fast-Food",
		"Take-Out",
		"Fast-Casual",
		"Casual",
		"Upscale",
		"American",
		"Italian",
		"Mexican",
		"Burgers",
		"Pizza",
		"Sandwiches",
		"Cuban",
		"Seafood",
		"Steak");

INSERT INTO restaurant (name, website, phone, lid) 
VALUES (("Versailles", "wwww.versaillesrestaurant.com", "(305) 444-0240", (SELECT id FROM location WHERE streetAddress="3555 SW 8th St" AND city="Miami" AND state="Florida" AND zip=33135),
		("Miami Smokers", "shopmiamismokers.com", "(786) 520-5420", (SELECT id FROM location WHERE streetAddress="306 NW 27th Ave" AND city="Miami" AND state="Florida" AND zip=33125),
		("Lokal", "wwww.lokalmiami.com", "(305) 442-3377", (SELECT id FROM location WHERE streetAddress="3190 Commodore Plaza" AND city="Miami" AND state="Florida" AND zip=33135),
		("Trulucks", "trulucks.com", "(305) 444-0240", (SELECT id FROM location WHERE streetAddress="777 Brickell Ave" AND city="Miami" AND state="Florida" AND zip=33131),
		("Perricone's", "wwww.perricones.com", "(305) 374-9449", (SELECT id FROM location WHERE streetAddress="15 SE 10th St" AND city="Miami" AND state="Florida" AND zip=33131)

INSERT INTO tag_restaurant (rid, tid) 
VALUES (((SELECT id FROM restaurant WHERE name = "Versailles"), (SELECT id FROM tag WHERE description="Casual")),
		((SELECT id FROM restaurant WHERE name = "Versailles"), (SELECT id FROM tag WHERE description="Cuban")),
		((SELECT id FROM restaurant WHERE name = "Miami Smokers"), (SELECT id FROM tag WHERE description="Take-Out")),
		((SELECT id FROM restaurant WHERE name = "Miami Smokers"), (SELECT id FROM tag WHERE description="Cuban")),
		((SELECT id FROM restaurant WHERE name = "Miami Smokers"), (SELECT id FROM tag WHERE description="Sandwiches")),
		((SELECT id FROM restaurant WHERE name = "Lokal"), (SELECT id FROM tag WHERE description="Casual")),
		((SELECT id FROM restaurant WHERE name = "Lokal"), (SELECT id FROM tag WHERE description="American")),
		((SELECT id FROM restaurant WHERE name = "Lokal"), (SELECT id FROM tag WHERE description="Burgers")),
		((SELECT id FROM restaurant WHERE name = "Trulucks"), (SELECT id FROM tag WHERE description="Upscale")),
		((SELECT id FROM restaurant WHERE name = "Trulucks"), (SELECT id FROM tag WHERE description="Seafood")),
		((SELECT id FROM restaurant WHERE name = "Trulucks"), (SELECT id FROM tag WHERE description="Steak")),
		((SELECT id FROM restaurant WHERE name = "Perricone's"), (SELECT id FROM tag WHERE description="Upscale")),
		((SELECT id FROM restaurant WHERE name = "Perricone's"), (SELECT id FROM tag WHERE description="Italian"))
		);

INSERT INTO review (uid, rid, rating, reviewtxt) 
VALUES ((SELECT id FROM user WHERE username='swinlaw'),(SELECT id FROM restaurant WHERE name = "Versailles"), 5, "Best spot for Cuban Food in Miami!"),
		(SELECT id FROM user WHERE username='fernandezd6'),(SELECT id FROM restaurant WHERE name = "Versailles"), 3, "Overrated. Good food but a bit of a tourist trap and there are too many other places to get great Cuban food in Miami"),
		(SELECT id FROM user WHERE username='fernandezd6'),(SELECT id FROM restaurant WHERE name = "Miami Smokers"), 4, "Amazing sandwiches! Not the fastest service, but worth the wait. My only complaint is that there was no where to sit down and eat, so plan on taking it to go."),
		(SELECT id FROM user WHERE username='swinlaw'),(SELECT id FROM restaurant WHERE name = "Lokal"), 5, "Best Burger in Miami"),
		(SELECT id FROM user WHERE username='fernandezd6'),(SELECT id FROM restaurant WHERE name = "Lokal"), 4, NULL),
		(SELECT id FROM user WHERE username='texas_pete'),(SELECT id FROM restaurant WHERE name = "Lokal"), 5, "My friend took me here while I was in town visiting. Great Food. Great Service. i would highly recommend it."),
		(SELECT id FROM user WHERE username='fernandezd6'),(SELECT id FROM restaurant WHERE name = "Trulucks"), 5, NULL),
		(SELECT id FROM user WHERE username='fernandezd6'),(SELECT id FROM restaurant WHERE name = "Perricone's"), 4, "Food is great. Atmosphere is beautiful. Service can be hit or miss.");
		(SELECT id FROM user WHERE username='swinlaw'),(SELECT id FROM restaurant WHERE name = "Perricone's"), 4, "Check out the $10 pasta nights on Thursday's. Such a great deal");

-- INSERT INTO location (streetAddress, city, state, zip) 
-- VALUES ();

-- INSERT INTO user (username, password, lid) 
-- VALUES ();

-- INSERT INTO tag (description) 
-- VALUES ();

-- INSERT INTO restaurant (name, website, phone, lid) 
-- VALUES ();

-- INSERT INTO tag_restaurant (rid, tid, phone, lid) 
-- VALUES ();

-- INSERT INTO review (uid, rid, rating, reviewtxt) 
-- VALUES ();