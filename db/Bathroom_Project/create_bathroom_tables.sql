CREATE TABLE users (
     user_id   SERIAL PRIMARY KEY
   , username  VARCHAR(16)  NOT NULL
   , email     VARCHAR(64)  NOT NULL
   , hash      VARCHAR(255) NOT NULL
   , is_male	 BOOLEAN		  NOT NULL
);

CREATE TABLE floors (
    floor_id    SERIAL PRIMARY KEY
,   floor_value INTEGER NOT NULL
);

CREATE TABLE buildings (
     building_id     SERIAL PRIMARY KEY
   , building_name   VARCHAR(25) NOT NULL
);

CREATE TABLE bathrooms (
    bathroom_id SERIAL  PRIMARY KEY
,	  is_mens     BOOLEAN
);

CREATE TABLE building_floor (
    building_floor_id SERIAL PRIMARY KEY
,   building_id       INTEGER REFERENCES buildings(building_id) NOT NULL
,   floor_id          INTEGER REFERENCES floors(floor_id) NOT NULL
);

CREATE TABLE bathrooms_building_floor (
	 bathrooms_building_floor_id 	SERIAL  PRIMARY KEY
,  building_floor_id 			 	    INTEGER REFERENCES building_floor(building_floor_id)
,	 bathroom_id  						    INTEGER REFERENCES bathrooms(bathroom_id)
);

CREATE TABLE ratings (
     rating_id       SERIAL  PRIMARY KEY
   , building_id     INTEGER REFERENCES buildings(building_id)
   , bathroom_id     INTEGER REFERENCES bathrooms(bathroom_id)
   , integrity_value INTEGER
   , overall_score   INTEGER NOT NULL
     CHECK (overall_score >= 0 AND overall_score <= 5)
   , cleanliness     INTEGER NOT NULL
     CHECK (cleanliness >= 1 AND cleanliness <= 5)
   , traffic         INTEGER
     CHECK (traffic >= 1 AND traffic <= 5)
   , echo_value      INTEGER
     CHECK (echo_value >= 1 AND echo_value <= 5)
   , stocked         BOOLEAN 
   , broken          BOOLEAN
   , single_stall    BOOLEAN
);

-- Insert into the floors table
INSERT INTO floors (floor_value) VALUES
  (0), -- index 1
  (1), -- index 2
  (2), -- index 3
  (3), -- index 4
  (4), -- index 5
  (5); -- index 6

-- Insert into the buildings
INSERT INTO buildings (building_name) VALUES 
  ('STC')
, ('Taylor')
, ('Austin');

-- Insert into the building_floor table
INSERT INTO building_floor (building_id, floor_id) VALUES
  (1, 2)  -- STC 1st floor
, (1, 3)  -- STC 2nd floor
, (1, 4); -- STC 3nd floor

-- Insert into the bathroom table (basiclly for whether it's male or female)
INSERT INTO bathrooms (is_mens) VALUES
	('TRUE')		-- Males 	restroom
,	('FALSE');	-- Females 	restroom


-- Insert into the building_floor table
INSERT INTO bathrooms_building_floor (building_floor_id, bathroom_id) VALUES
	(1, 1)	-- Male   STC 1st Floor
,	(1, 2)	-- Female STC 1st Floor
,	(2, 1)	-- Male   STC 2st Floor
,	(2, 2)	-- Female STC 2st Floor
,	(3, 1)	-- Male   STC 3st Floor
,	(3, 2);	-- Female STC 3st Floor


-- For home page query
SELECT bbf.building_floor_id      AS "Building Floor"
    ,      bbf.bathroom_id        AS "Bathroom ID"
    ,      b.building_name        As "Building Name"
    ,      b.building_id          AS "Building ID"
    FROM   bathrooms_building_floor  bbf
    ,      buildings                 b
    WHERE  bbf.building_floor_id = b.building_id


















    