--Corvallis Restaraunts

--1
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("1425 NW Monroe Ave HB","Corvallis","OR",97330);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("Local Boyz Hawaiian Cafe","localboyzhawaiiancafe.com","(541) 754-5338",
(SELECT id FROM location 
WHERE streetAddress="1425 NW Monroe Ave HB" AND city="Corvallis" AND state="OR"
AND zip=97330);

--2
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("1416 NW 9th St.","Corvallis","OR",97330);

INSERT INTO restaurant (name, phone, lid) 
VALUES ("La Roca","(541) 753-7143",
(SELECT id FROM location 
WHERE streetAddress="1416 NW 9th St." AND city="Corvallis" AND state="OR"
AND zip=97330);

--3
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("1597 NW 9th St.","Corvallis","OR",97330);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("El Sol De Mexico","elsoldemexico.cc",,"(541) 752-9299",
(SELECT id FROM location 
WHERE streetAddress="1597 NW 9th St." AND city="Corvallis" AND state="OR"
AND zip=97330);

--4
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("2307 NW 9th St.,"Corvallis","OR",97330);

INSERT INTO restaurant (name,website, phone, lid) 
VALUES ("China Blue Restaurant","chinabluerestaurant.com","(541) 757-8088",
(SELECT id FROM location 
WHERE streetAddress="2307 NW 9th St." AND city="Corvallis" AND state="OR"
AND zip=97330);

--5
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("136 SW Washington Ave","Corvallis","OR",97330);

INSERT INTO restaurant (name,website, phone, lid) 
VALUES ("del Alma","delalmarestaurant.com","(541) 753-2222",
(SELECT id FROM location 
WHERE streetAddress="136 SW Washington Ave" AND city="Corvallis" AND state="OR"
AND zip=97330);

--Houston
--1
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("110 Vintage Park Blvd","Houston","TX",77070);

INSERT INTO restaurant (name, phone, lid) 
VALUES ("Mia Bella Trattoria","(281) 251-8930",
(SELECT id FROM location 
WHERE streetAddress="110 Vintage Park Blvd" AND city="Houston" AND state="TX"
AND zip=77070);

--2
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("19550 TX-249","Houston","TX",77070);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("Red Fish Seafood Gril","www.redfishhouston.com","(281) 970-8599",
(SELECT id FROM location 
WHERE streetAddress="19550 TX-249" AND city="Houston" AND state="TX"
AND zip=77070);

--3
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("3300 Smith St","Houston","TX", 77006);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("Brennan's of Houston","www.brennanshouston.com","(713) 522-9711",
(SELECT id FROM location 
WHERE streetAddress="3300 Smith St" AND city="Houston" AND state="TX"
AND zip=77006);

--4
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("122 Vintage Park Blvd","Houston","TX", 77070);

INSERT INTO restaurant (name, phone, lid) 
VALUES ("Strata Restaurant and Bar", "(281) 379-2889",
(SELECT id FROM location 
WHERE streetAddress="122 Vintage Park Blvd" AND city="Houston" AND state="TX"
AND zip=77070);

--5
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("1103 S Shepherd Dr","Houston","TX", 77019);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("Backstreet Cafe","www.backstreetcafe.net","(713) 521-2239",
(SELECT id FROM location 
WHERE streetAddress="1103 S Shepherd Dr" AND city="Houston" AND state="TX"
AND zip=77019);

--New York
--1
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("1 Central Park West","New York","NY", 10023);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("Jean-Georges","http://places.singleplatform.com/jean-georges/menu?ref=google","(212) 299-3900",
(SELECT id FROM location 
WHERE streetAddress="1 Central Park West" AND city="New York" AND state="NY"
AND zip=10023);
--2
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("10 Columbus Cir","New York","NY", 10019);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("Per Se","http://www.thomaskeller.com/new-york-new-york/per-se/todays-menus","(212) 823-9335",
(SELECT id FROM location 
WHERE streetAddress="10 Columbus Cir" AND city="New York" AND state="NY"
AND zip=10019);
--3
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("60 E 65th St","New York","NY", 10065);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("Daniel","www.danielnyc.com","(212) 288-0033",
(SELECT id FROM location 
WHERE streetAddress="60 E 65th St" AND city="New York" AND state="NY"
AND zip=10065);
--4
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("99 E 52nd St","New York","NY", 10022);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("The Four Seasons","http://www.opentable.com/the-four-seasons-restaurant-the-pool-room?ref=1068","(212) 754-9494",
(SELECT id FROM location 
WHERE streetAddress="99 E 52nd St" AND city="New York" AND state="NY"
AND zip=10022);
--5
INSERT INTO location (streetAddress, city, state, zip) 
VALUES ("11 Madison Ave","New York","NY", 10010);

INSERT INTO restaurant (name, website, phone, lid) 
VALUES ("Eleven Madison Park","http://www.opentable.com/eleven-madison-park?ref=1068","(212) 889-0905",
(SELECT id FROM location 
WHERE streetAddress="11 Madison Ave" AND city="New York" AND state="NY"
AND zip=10010);